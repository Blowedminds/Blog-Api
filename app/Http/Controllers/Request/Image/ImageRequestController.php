<?php

namespace App\Http\Controllers\Request\Image;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\AuthApi;
use App\Http\Controllers\Api\ImageApi;

use Illuminate\Support\Facades\Storage;

use App\Image;
use ImageFactory;

class ImageRequestController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth', ['only' => ['addImage', 'getImages']]);
  }

  public function postImage(Request $request)
  {
    $this->validate($request, [
      'file' => 'required|image|max:33554432',
      'public' => 'required',
      'alt' => 'required'
    ]);

    $user = AuthApi::authUser();

    if (!$request->hasFile('file') && !$file->isValid())
      return API::responseApi([
        'header' => 'Dosya Hatası', 'message' => 'Dosyayı alamadık', 'state' => 'error'
      ]);

    $file = $request->file('file');

    $extension = $file->extension();

    $u_id = uniqid('img_');

    $hash = md5_file($file->getRealPath());

    $name = ($request->has('name') && $request->input('name') != "")? $request->input('name') : pathInfo($file->getClientOriginalName(),PATHINFO_FILENAME);

    $store_name = $u_id.".".$extension;

    $size = $file->getClientSize();

    $path = "albums/$u_id/";

    $alt = $request->input('alt');

    /*Check if file already exists*/
    if (Storage::disk('local')->exists($path.$store_name) && $temp = Image::where('u_id', $u_id)->first())
      return API::responseApi([
        'header' => 'Dosya Hatası', 'message' => 'Dosya oluştururken bir hata oluştu', 'state' => 'error'
      ]);

    $img = ImageFactory::make($file->getRealPath());

    $original_image = ImageFactory::make($file->getRealPath());

    $webp = ImageFactory::make($file->getRealPath());

    $thumb_nail = ImageFactory::make($file->getRealPath());

    $height = $img->height();

    $width = $img->width();

    if ($width >= 128 || $height >= 128)
      $thumb_nail = ($width > $height) ? $thumb_nail->resize(128, null, function($c) {$c->aspectRatio();}) : $thumb_nail->resize(null, 128, function($c) {$c->aspectRatio();});

    Storage::put($path.$store_name, $original_image->encode($extension, null));

    Storage::put($path.$u_id.".webp", $webp->encode('webp', null));

    Storage::put($path.'thumb_'.$store_name, $thumb_nail->encode($extension, null));

    $image = Image::create([
      'u_id' => $u_id,
      'size' => $size,
      'name' => $name,
      'hash' => $hash,
      'height' => $height,
      'width' => $width,
      'type' => $extension,
      'alt' => $alt,
      'owner' => $user->user_id,
      'public' => ($request->input('public')) ? 1 : 0
    ]);

    return API::responseApi([
      'header' => 'İşlem Başarılı', 'message' => 'Fotoğrafı albüme kaydettik', 'state' => 'success'
    ], 200);
  }

  public function getImages()
  {
    $user = AuthApi::authUser();

    $public = Image::where('public', 1)->get();

    $private = Image::where('owner', $user->user_id)->where('public', 0)->get();

    $data = ['public' => [], 'private' => []];

    $i = 0;

    foreach ($public as $key => $value) {

      $data['public'][$i]['name'] = $value->name;
      $data['public'][$i]['size'] = $value->size;
      $data['public'][$i]['width'] = $value->width;
      $data['public'][$i]['height'] = $value->height;
      $data['public'][$i]['type'] = $value->type;
      $data['public'][$i]['alt'] = $value->alt;
      $data['public'][$i]['u_id'] = $value->u_id;

      $i++;
    }
    $i = 0;
    foreach ($private as $key => $value) {

      $data['private'][$i]['name'] = $value->name;
      $data['private'][$i]['size'] = $value->size;
      $data['private'][$i]['width'] = $value->width;
      $data['private'][$i]['height'] = $value->height;
      $data['private'][$i]['type'] = $value->type;
      $data['private'][$i]['alt'] = $value->alt;
      $data['private'][$i]['u_id'] = $value->u_id;

      $i++;
    }

    return response()->json($data, 200);
  }

  public function getThumb($image)
  {
    $not_found_response = ['header' => 'Hata', 'message' => 'Fotoğrafı bulamadık', 'state' => 'error'];

    if(!$image = ImageApi::isAccessible($image))
      return API::responseApi($not_found_response);

    return ImageApi::file(storage_path('/app/albums/'.$image->u_id.'/thumb_'.$image->u_id.".".$image->type),
                          ['Content-Type' => "image/$image->type"]
                        );
  }

  public function getImage($image)
  {
    $not_found_response = ['header' => 'Hata', 'message' => 'Fotoğrafı bulamadık', 'state' => 'error'];

    if(!$image = ImageApi::isAccessible($image))
      return API::responseApi($not_found_response);

    return ImageApi::file(storage_path('/app/albums/'.$image->u_id.'/'.$image->u_id.".".$image->type),
                            ['Content-Type' => "image/$image->type"]
                          );
  }

  public function getEdit($image)
  {
    $user = AuthApi::authUser();

    if(!$image = self::canEditImage($image, $user->user_id))
        return API::responseApi([
          'header' => 'Hata', 'message' => 'Aradığınız albüm ya yok yada erişemiyorsunuz'
        ]);

    $data['name'] = $image->name;
    $data['size'] = $image->size;
    $data['width'] = $image->width;
    $data['height'] = $image->height;
    $data['type'] = $image->type;
    $data['alt'] = $image->alt;
    $data['u_id'] = $image->u_id;
    $data['public'] = $image->public ? true : false;

    return response()->json($data, 200);
  }

  public function putEdit($image, Request $request)
  {
    $user = AuthApi::authUser();

    $this->validate($request, [
      'u_id' => 'required',
      'name' => 'required',
      'alt' => 'required',
      'save_as' => 'required',
      'public' => 'required'
    ]);

    if ($request->input('u_id') != $image)
      return API::responseApi([
              'header' => 'Hata', 'message' => 'U_ID != IMAGE_URL', 'state' => 'error'
            ]);


    if(!$image = self::canEditImage($image, $user->user_id))
      return API::responseApi([
              'header' => 'Hata', 'message' => 'Aradığınız albüm ya yok yada erişemiyorsunuz', 'state' => 'error'
            ]);

    $crop = $request->input('crop');
    $save_as = $request->input('save_as');
    $name = $request->input('name');
    $alt = $request->input('alt');
    $width = $image->width;
    $height = $image->height;
    $u_id = $save_as ? uniqid('img_') : $image->u_id;
    $public = intval($request->input('public')) ? 1 : 0;


    if($crop == 1){

      $width = $request->input('width');
      $height = $request->input('height');
      $x = $request->input('x');
      $y = $request->input('y');
      $rotate = - $request->input('rotate');

      $edit_image = ImageFactory::make(storage_path()."/app/albums/$image->u_id/$image->u_id.$image->type");
      $thumb_nail = ImageFactory::make(storage_path()."/app/albums/$image->u_id/$image->u_id.$image->type");
      $webp = ImageFactory::make(storage_path()."/app/albums/$image->u_id/$image->u_id.$image->type");

      $edit_image->rotate($rotate);

      $edit_image->crop($width, $height, $x, $y);

      $thumb_nail->rotate($rotate);

      $thumb_nail->crop($width, $height, $x, $y);

      $webp->rotate($rotate);

      $webp->crop($width, $height, $x, $y);


      Storage::put("albums/$u_id/$u_id.$image->type", $edit_image->encode($image->type, null));

      Storage::put("albums/$u_id/$u_id.webp", $webp->encode('webp', null));

      if ($width >= 128 || $height >= 128)
        $thumb_nail = ($width > $height) ? $thumb_nail->resize(128, null, function($c) {$c->aspectRatio();}) : $thumb_nail->resize(null, 128, function($c) {$c->aspectRatio();});

      Storage::put("albums/$u_id/thumb_$u_id.$image->type", $thumb_nail->encode($image->type, null));

      $image->hash = ($save_as == 1) ? md5(storage_path()."/app/albums/$u_id/$u_id.$image->type") : $image->hash;
    }elseif ($crop == 0 && $save_as == 1) {
      $edit_image = Storage::get("albums/$image->u_id/$image->u_id.$image->type");
      $thumb_nail = Storage::get("albums/$image->u_id/thumb_$image->u_id.$image->type");
      $webp = Storage::get("albums/$image->u_id/$image->u_id.webp");

      Storage::put("albums/$u_id/$u_id.$image->type", $edit_image);
      Storage::put("albums/$u_id/$u_id.webp", $webp);
      Storage::put("albums/$u_id/thumb_$u_id.$image->type", $thumb_nail);
    }

    if($save_as == 1){

      Image::create([
        'u_id' => $u_id,
        'size' => Storage::size("albums/$u_id/$u_id.$image->type"),
        'name' => $name,
        'hash' => md5(storage_path()."/app/albums/$u_id/$u_id.$image->type"),
        'height' => $height,
        'width' => $width,
        'type' => $image->type,
        'alt' => $alt,
        'owner' => $user->user_id,
        'public' => $public
      ]);
    }else {
      if($crop == 1) $image->size = Storage::size("albums/$u_id/$u_id.$image->type");

      $image->name = $name;
      $image->alt = $alt;
      $image->public = $public;
      $image->save();
    }

    return API::responseApi([
            'header' => 'İşlem Başarılı', 'message' => 'Fotoğraf başarı ile düzenlendi', 'state' => 'success'
          ], 200);
  }

  public function deleteImage($image)
  {
    $user = AuthApi::authUser();

    $not_found_access_denied = ['header' => 'Hata', 'message' => 'Aradığınız albüm ya yok yada erişemiyorsunuz', 'state' => 'error'];

    if(!$image = self::canEditImage($image, $user->user_id))
        return API::responseApi($not_found_access_denied);

    $path = "albums/$image->u_id";

    $file = Storage::deleteDirectory($path);

    $image->forceDelete();

    return API::responseApi([
      'header' => 'İşlem Başarılı', 'message' => 'Dosyalar başarı ile silindi!', 'state' => 'success'
    ], 200);

  }

  protected static function canEditImage($image_u_id, $user_id)
  {
    if(!$image = Image::where('u_id', $image_u_id)->first())
      return false;

    if(!($image->public == 0 && $image->owner == $user_id) && $image->public == 0)
      return false;

    return $image;
  }
}
