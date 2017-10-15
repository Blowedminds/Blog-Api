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
}
