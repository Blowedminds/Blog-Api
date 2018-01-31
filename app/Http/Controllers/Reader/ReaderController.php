<?php

namespace App\Http\Controllers\Reader;

use App\Category;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\PublicApi;



use App\Role;
use App\Article;
use App\Language;
use App\Image;

class ReaderController extends Controller
{
    public function __construct()
    {
    }

  public function getMenus($locale)
  {
    $menus = Role::find(3)->menus->map( function($menu) {
      return [
        'name' => $menu->name,
        'tooltip' => $menu->tooltip,
        'url' => $menu->url,
        'weight' => $menu->weight
      ];
    })->toArray();

    usort($menus, function($a, $b) {
        return $a['weight'] - $b['weight'];
    });

    return response()->json($menus, 200);
  }

  public function getLanguages($locale)
  {
    $languages = Language::all()->map( function ($language) {
        return [
          'name' => $language->name,
          'slug' => $language->slug
        ];
    });

    return API::responseApi($languages, 200);
  }

  public function getHomeData($locale)
  {
    $data = ['most_viewed' => [], 'latest' => []];

    $locale = Language::where('slug', $locale)->first();

    return response()->json($data, 200);
  }

  public function getAboutMe($locale)
  {
    return response()->json(['Locale: '.$locale], 200);
  }

  public function getImage($image)
  {
    $not_found_response = ['header' => 'Hata', 'message' => 'Resmi bulamadık', 'state' => 'error'];

    if(!$query = Image::where('u_id', $image)->first()){
        return API::responseApi($not_found_response);
    }

    if ($query->public == 0) {
      return API::responseApi($not_found_response);
    }

    return response()->file(storage_path('/app/albums/'.$query->u_id.'/'.$query->u_id.".$query->type"), ['Content-Type' => 'image/'.$query->type]);
  }

  public function getCategories()
  {
      $categories = Category::all()->map( function ($category) {

          return [
              'id' => $category->id,
              'name' => $category->name,
              'description' => $category->description,
              'slug' => $category->slug
          ];
      });

    return response()->json($categories, 200);
  }

}
