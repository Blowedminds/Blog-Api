<?php

namespace App\Http\Controllers\Request\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\UserApi;

class UserRequestController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getUserInfo()
  {
    $user = API::authUser();

    $data['name'] = $user->name;

    $data['user_id'] = $user->user_id;

    $data['role_id'] = $user->roles()->first()->id;

    return response()->json($data);
  }
}
