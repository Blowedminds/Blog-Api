<?php
namespace App\Http\Controllers\Api;

use App\Language;
use App\Category;
use Illuminate\Http\Request;
use App\Exceptions\UnknownLanguageException;

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

  public static function getLanguage()
  {
      if(!$language = Language::where('slug', request()->route('locale'))->first()) {

          throw new UnknownLanguageException;
      }

      return $language;
  }
  public static function getCategory()
  {
      if(!$category = Category::where('slug', request()->route('category_slug'))->first()) {

          throw new UnknownLanguageException;
      }

      return $category;
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
