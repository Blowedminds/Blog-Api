<?php

namespace App\Http\Controllers\Request\PublicR;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\PublicApi;



use App\Role;
use App\Article;
use App\Language;
use App\Image;

class PublicRequestController extends Controller
{
  public function getMenus($locale)
  {
    $menus = Role::find(3)->menus;

    $data = []; $i = 0;

    foreach ($menus as $key => $value) {

      $data[$i]['name'] = $value->menu_name;
      $data[$i]['tooltip'] =  $value->menu_tooltip;
      $data[$i]['url'] = $value->menu_url;
      $data[$i]['weight'] = $value->menu_weight;

      $i++;
    }

    $data = array_unique($data, SORT_REGULAR);

    usort($data, function($a, $b) {
        return $a['weight'] - $b['weight'];
    });

    return response()->json($data, 200);
  }

  public function getLanguages($locale)
  {
    $languages = Language::all();

    $data = []; $i = 0;

    foreach ($languages as $key => $value) {
      $data[$i]['name'] = $value->name;
      $data[$i]['slug'] = $value->slug;

      $i++;
    }

    return API::responseApi($data, 200);
  }

  public function getHomeData($locale)
  {
    $data = ['most_viewed' => [], 'latest' => []];

    $locale = Language::where('slug', $locale)->first();

    //$data['most_viewed'] = PublicApi::getMostViewed($locale->id);

    //$data['latest'] = PublicApi::getLatest($locale->id);

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
    $category = API::categories();

    $k = 0; $categories = [];

    foreach ($category as $key => $value) {

      $categories[$k]['id'] = $value->id;
      $categories[$k]['name'] = $value->name;
      $categories[$k]['description'] = $value->description;

      $k++;
    }

    return response()->json($categories, 200);
  }

}
