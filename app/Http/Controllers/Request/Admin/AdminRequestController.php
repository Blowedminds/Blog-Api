<?php

namespace App\Http\Controllers\Request\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;

class AdminRequestController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getMenus(Request $request)
  {
    $user = API::authUser();

    $menus = $user->menusByRole();

    $data = []; $i = 0;

    foreach ($menus as $key => $value) {

      $data[$i]['name'] = $value->menu_name;
      $data[$i]['url'] = $value->menu_url;
      $data[$i]['tooltip'] = $value->menu_tooltip;
      $data[$i]['weight'] = $value->menu_weight;

      $i++;
    }

    $data = array_unique($data, SORT_REGULAR);

    usort($data, function($a, $b) {
        return $b['weight'] - $a['weight'];
    });

    return response()->json($data, 200);
  }

  public function getAlbums()
  {
    return response()->json('Success', 200);
  }
}
