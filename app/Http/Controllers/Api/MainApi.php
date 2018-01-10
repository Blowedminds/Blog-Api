<?php
namespace App\Http\Controllers\Api;

use App\Language;
use App\Category;
use App\Article;

class MainApi
{

  public static function languages()
  {
    return Language::all();
  }

  public static function categories()
  {
    return Category::all();
  }

  public static function redirectApi($data)
  {
    return response()->json($data, 421);
  }

  public static function responseApi($data, $status = null)
  {
    $status = $status ? $status : 422;

    return response()->json($data, $status);
  }
}
