<?php

namespace App\Http\Controllers\Editor;

use App\Category;
use App\Language;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\AuthApi;

class EditorRequestController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api');
  }

  public function getGlobalData()
  {
    $languages = Language::all()->map( function ($language) {
       return [
          'id' => $language->id,
          'name' => $language->name,
          'slug' => $language->slug
       ];
    });

    $categories = Category::all()->map( function ($category) {

        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,

        ];
    });

    return response()->json([
        'languages' => $languages,
        'categories' => $categories
    ], 200);
  }
}
