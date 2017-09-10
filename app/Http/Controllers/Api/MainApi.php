<?php

namespace App\Http\Controllers\Api;

class MainApi
{
  public static function authUser()
  {
      try {

          if (! $user = app('auth')->authenticate()) {
              return false;
          }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return false;

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return false;

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return false;

        } catch (\Illuminate\Auth\AuthenticationException $e) {

            return false;

        }

      // the token is valid and we have found the user via the sub claim
      return $user;
  }

  public static function languages()
  {
    return \App\Language::all();
  }

  public static function categories()
  {
    return \App\Category::all();
  }

  public static function articleAvailableLanguages($article_id)
  {
    if(!$languages = \App\Article::find($article_id)->availableLanguages)
      return false;

    $data = []; $i = 0;

    foreach ($languages as $key => $value) {

      $data[$i]['name'] = $value->name;
      $data[$i]['slug'] = $value->slug;

      $i++;
    }
    return $data;
  }

  public static function trashedArticle($user)
  {
    if(!$roles = $user->rolesByRoleId(1)->first()){
      $articles = \App\Article::onlyTrashed()->where('author', $user->user_id)->with(['trashed_contents', 'author' => function($query) {$query->select('user_id', 'name');}])->paginate(15);
    }else {
      $articles = \App\Article::onlyTrashed()->with(['trashed_contents', 'author' => function($query) {
        $query->select('user_id', 'name');
      }])->paginate(15);
    }
    return $articles;
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
