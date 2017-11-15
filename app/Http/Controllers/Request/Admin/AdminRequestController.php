<?php

namespace App\Http\Controllers\Request\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\AuthApi;

class AdminRequestController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getGlobalData()
  {
    $language = API::languages();

    $i = 0; $languages = [];

    foreach ($language as $key => $value) {

      $languages[$i]['id'] = $value->id;
      $languages[$i]['name'] = $value->name;
      $languages[$i]['slug'] = $value->slug;

      $i++;
    }

    $category = API::categories();

    $k = 0; $categories = [];

    foreach ($category as $key => $value) {

      $categories[$k]['id'] = $value->id;
      $categories[$k]['name'] = $value->name;
      $categories[$k]['description'] = $value->description;

      $k++;
    }

    $data['languages'] = $languages;
    $data['categories'] = $categories;

    return response()->json($data, 200);
  }
}
