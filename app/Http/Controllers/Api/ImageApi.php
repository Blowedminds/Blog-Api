<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

use App\Image;

class ImageApi
{

  public static function file($file, $headers)
  {
    return new BinaryFileResponse($file, 200, $headers);
  }

  public static function isPublic($image_id)
  {
    if(!$query = Image::where('u_id', $image_id)->first())  return false;

    if ($query->public == 1) return $query;

    if(!$user = MainApi::authUser())  return false;

    if($query->owner != $user->user_id) return false;

    return $query;
  }

}
