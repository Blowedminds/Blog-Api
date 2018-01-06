<?php

namespace App\Http\Controllers\Request\PublicR\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\PublicApi;

use App\User;
use App\UserData;
use App\Article;
use App\ArticleContent;
use App\Category;
use App\Language;

class PublicArticleController extends Controller
{
    public function getArticleSingle($language, $slug)
    {
      $response = [
        'header' => 'Hata',
        'message' => 'Aradığınız Makaleyi Bulamadık',
        'state' => 'error',
        'link' => 'home',
        'pop_up' => true
      ];

      if(!$language = Language::where('slug', $language)->first())

        return API::responseApi($response);

      $language_id = $language->id;

      if(!$article = Article::where('slug', $slug)->with(['contents' => function ($query) use($language_id){
        $query->where('language', $language_id)->where('published', 1);
      }, 'categories'])->first())

        return API::responseApi($response);

      if (!isset($article->contents[0]))

        return API::responseApi($response);

      $temp_categories = []; $i = 0;

      foreach ($article->categories as $key => $value) {
        $temp_categories[$i] = $value->name;
        $i++;
      }

      $article_content = $article->contents[0];

      $author = UserData::where('user_id', $article->author)->first();

      $data['title'] = $article_content->title;
      $data['sub_title'] = $article_content->sub_title;
      $data['body'] = $article_content->body;
      $data['keywords'] = $article_content->keywords;
      $data['categories'] = $temp_categories;
      $data['available_languages'] = API::articleAvailableLanguages($article->id);
      $data['slug'] = $article->slug;
      $data['image'] = $article->image;

      $data['author']['name'] = $author->name;
      $data['author']['profile_image'] = $author->profile_image;
      $data['author']['bio'] = "";

      $bio = json_decode($author->biography ?? []);

      if($bio){
          $key = array_search( $language->slug, array_column($bio, 'slug'));

          if($key === 0 || $key) $data['author']['bio'] = $bio[$key]->bio;
      }


      $article->views = $article->views + 1;

      $article->save();

      return response()->json($data, 200);
    }

    public function getMostVieweds($locale)
    {
      $response = [
        'header' => 'Hata', 'message' => 'Aradığınız Makaleyi Bulamadık', 'state' => 'error', 'pop_up' => true
      ];

      if(!$language = Language::where('slug', $locale)->first())
        return API::responseApi($response);

      return response()->json(PublicApi::getMostViewed($language->id), 200);
    }

    public function getLatests($locale)
    {
      $response = [
        'header' => 'Hata', 'message' => 'Aradığınız Makaleyi Bulamadık', 'state' => 'error', 'pop_up' => true
      ];

      if(!$language = Language::where('slug', $locale)->first())
        return API::responseApi($response);

      return response()->json(PublicApi::getLatest($language->id), 200);
    }

    public function getArticlesByCategory($locale, $category_slug)
    {
      if(!$category = Category::where('slug', $category_slug)->first())
        return API::responseApi([
          'header' => 'Hata', 'message' => 'Aradığınız Kategori sistemimizde kayıtlı değil', 'state' => 'error', 'pop_up' => true
        ]);

      if(!$language = Language::where('slug', $locale)->first())
        return API::responseApi([
          'header' => 'Hata', 'message' => 'Aradığınız Dil sistemimizde kayıtlı değil', 'state' => 'error', 'pop_up' => true
        ]);

      $articles = PublicApi::getArticlesByCategory($language->id, $category);

      return response()->json($articles, 200);
    }

    public function getArticlesBySearch($locale, Request $request)
    {
      if(!$language = Language::where('slug', $locale)->first())
        return API::responseApi([
          'header' => 'Hata', 'message' => 'Aradığınız Dil sistemimizde kayıtlı değil', 'state' => 'error', 'pop_up' => true
        ]);

      $query = $request->input('q');

      return ArticleContent::where('title', 'like', '%'.$query.'%')->where('language', $language->id)->get();
    }

    public function getArticleByDetailedSearch()
    {

    }

    public function getArticlesByArchive(Request $request)
    {
      //$article = Article::where('');
    }

}
