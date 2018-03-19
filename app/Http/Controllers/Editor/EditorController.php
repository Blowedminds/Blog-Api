<?php

namespace App\Http\Controllers\Editor;

use App\Category;
use App\Language;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\AuthApi;

class EditorController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api');
  }
}
