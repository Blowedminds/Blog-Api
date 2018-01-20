<?php

namespace App\Http\Controllers\Reader\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\PublicApi;


use App\Article;
use App\Category;

class ReaderArticleController extends Controller
{
    private $language;

    public function __construct()
    {
        $this->language = API::getLanguage();
    }

    public function getArticleSingle($language, $slug)
    {
      $response = [
        'header' => 'Hata',
        'message' => 'Aradığınız Makaleyi Bulamadık',
        'state' => 'error',
        'redirect_link' => '/',
        'pop_up' => true
      ];

      if(!$article = Article::where('slug', $slug)->with(['contents' => function ($query){
        $query->where('language_id', $this->language->id)->where('published', 1);
      }, 'categories', 'author'])->first())

        return API::responseApi($response);

      if (!isset($article->contents[0]))

        return API::responseApi($response);

      $temp_categories = [];

      foreach ($article->categories as $key => $value) {
        $temp_categories[] = $value->name;
      }

      $article_content = $article->contents[0];

      $availableLanguages = $article->availableLanguages->map(function($language) {

        return [
          'name' => $language->name,
          'slug' => $language->slug
        ];
      });

      $data['title'] = $article_content->title;
      $data['sub_title'] = $article_content->sub_title;
      $data['body'] = $article_content->body;
      $data['keywords'] = $article_content->keywords;
      $data['categories'] = $temp_categories;
      $data['available_languages'] = $availableLanguages;
      $data['slug'] = $article->slug;
      $data['image'] = $article->image;

      $data['author']['name'] = $article->author->name;
      $data['author']['profile_image'] = $article->author->userData->profile_image;
      $data['author']['bio'] = "";

      $bio = json_decode($article->author->userData->biography ?? []);

      if($bio){
          $key = array_search( $this->language->slug, array_column($bio, 'slug'));

          if($key === 0 || $key) $data['author']['bio'] = $bio[$key]->bio;
      }

      $article->views = $article->views + 1;

      $article->save();

      return response()->json($data, 200);
    }

    public function getMostVieweds()
    {
      return response()->json(PublicApi::getMostViewed($this->language->id), 200);
    }

    public function getLatests()
    {
      $response = [
        'header' => 'Hata', 'message' => 'Bu dil desteklenmemektedir', 'state' => 'error', 'pop_up' => false, 'redirect_link' => '/'
      ];

      return response()->json(PublicApi::getLatest($this->language->id), 200);
    }

    public function getArticlesByCategory($locale, $category_slug)
    {
        $category = API::getCategory();

        $articles = $category->articles()->whereHas('contents', function($q) {
           $q->where('language_id', $this->language->id);
        })->with('contents')->paginate(10);

        return response()->json($articles, 200);
    }

    public function getArticlesBySearch($locale, Request $request)
    {
      $query = $request->input('q');

      $articles = Article::whereHas('contents', function ($q) use($query) {
          $q->where('title', 'like', '%'.$query.'%')->where('language_id', $this->language->id);
      })->with('contents')->get();

      return response()->json($articles, 200);
    }

    public function getArticleByDetailedSearch()
    {
    }

    public function getArticlesByArchive(Request $request)
    {
    }

}
