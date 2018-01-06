<?php

namespace App\Http\Controllers\Request\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

use App\Language;
use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\AuthApi;
use App\Http\Controllers\Api\UserApi;
use App\Exceptions\CustomExceptions\InValidInputException;

class UserRequestController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getUserInfo()
  {
    $user = AuthApi::authUser();

    $data['name'] = $user->name;

    $data['user_id'] = $user->user_id;

    $data['role_id'] = $user->roles()->first()->id;

    return response()->json($data);
  }

  public function getUserProfile()
  {
    $user = AuthApi::authUser();

    $user_data = $user->userData;

    $user_bio = json_decode($user_data->biography);

    $data['bio'] = Language::all('slug')->map( function($language) use($user_bio) {

        if($user_bio){
            $key = array_search($language->slug, array_column($user_bio, 'slug'));
        }
        else{
            $key = false;
        }

        return [
            'slug' => $language->slug,
            'bio' => $key !== false ? $user_bio[$key]->bio : null
        ];
    });

    $role = $user->roles()->first();

    $data['profile_image'] = $user_data->profile_image;

    $data['name'] = $user->name;

    $data['user_id'] = $user->user_id;

    $data['role_id'] = $role->id;

    $data['role_name'] = $role->role_name;

    return response()->json($data);
  }

  public function postUserProfile(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'bio' => 'required'
    ]);

    if($this->isValidBio($request->input('bio'))){
        throw new InValidInputException;
    }

    $user = AuthApi::authUser();

    $user->name = $request->input('name');

    $user_data = $user->userData;

    $user_data->biography = json_encode($request->input('bio'));

    $user_data->save();

    $user->save();

    return response()->json(['Tebrikler'], 200);
  }

  public function postUserProfileImage(Request $request)
  {
    $this->validate($request, [
      'file' => 'required|image|max:33554432',
    ]);

    if (!$request->hasFile('file') && !$file->isValid())
      return API::responseApi([
        'header' => 'Dosya Hatası', 'message' => 'Dosyayı alamadık', 'state' => 'error'
      ]);

    $user = AuthApi::authUser();

    $user_data = $user->userData;

    $file = $request->file('file');

    $extension = $file->extension();

    $u_id = uniqid('img_');

    $store_name = $u_id.".".$extension;

    File::delete("images/author/".$user_data->profile_image);

    $user_data->profile_image = $store_name;

    $user_data->save();

    $path = rtrim(app()->basePath('public/'."images/author"), '/');

    $request->file('file')->move($path, $store_name);

    return response()->json(['TEBRIKLER'], 200);
  }

  public function getMenus(Request $request)
  {
    $user = AuthApi::authUser();

    $menus = $user->menusByRole();

    $data = []; $i = 0;

    foreach ($menus as $key => $value) {

      $data[$i]['name'] = $value->name;
      $data[$i]['url'] = $value->url;
      $data[$i]['tooltip'] = $value->tooltip;
      $data[$i]['weight'] = $value->weight;

      $i++;
    }

    $data = array_unique($data, SORT_REGULAR);

    usort($data, function($a, $b) {
        return $b['weight'] - $a['weight'];
    });

    return response()->json($data, 200);
  }

  private function isValidBio($bio)
  {
      $is_valid = Language::all('slug')->reduce(function($carry, $language) use($bio){

          return $carry && ($bio[$language->slug] ?? null);
      }, true);

      return (bool) $is_valid;
  }
}
