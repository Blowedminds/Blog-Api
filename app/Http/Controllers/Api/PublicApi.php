<?php

namespace App\Http\Controllers\Api;

use App\Article;

class PublicApi
{
  public static function getMostViewed($locale_id)
  {
    $most_viewed = Article::orderBy('views', 'DESC')->with(['contents' => function ($query) use($locale_id){
      $query->where('language', $locale_id)->where('published', 1);
    }, 'categories'])->take(10)->get();

    $data = []; $i = 0;

    foreach ($most_viewed as $key => $article) {

      if($i >= 5) break;

      if(!isset($article->contents[0])) continue;

      //$data[$i]['content']['body'] = $article->contents[0]->body;
      $data[$i]['content']['image_url'] = $article->contents[0]->image_url;
      $data[$i]['content']['keywords'] = $article->contents[0]->keywords;
      $data[$i]['content']['sub_title'] = $article->contents[0]->sub_title;
      $data[$i]['content']['title'] = $article->contents[0]->title;

      $data[$i]['categories'] = $article->categories;
      $data[$i]['author'] = $article->author_id;
      $data[$i]['image'] = $article->image;
      $data[$i]['slug'] = $article->slug;
      $data[$i]['views'] = $article->views;
      $data[$i]['created_at'] = $article->created_at;

      $i++;
    }

    return $data;
  }

  public static function getLatest($locale_id)
  {
    $latest = Article::orderBy('created_at', 'DESC')->with(['contents' => function ($query) use($locale_id){
      $query->where('language', $locale_id)->where('published', 1);
    }, 'categories'])->take(20)->get();

    $data = []; $i = 0;

    foreach ($latest as $key => $article) {

      if($i >= 7) break;

      if(!isset($article->contents[0])) continue;

      //$data[$i]['content']['body'] = $article->contents[0]->body;
      $data[$i]['content']['image_url'] = $article->contents[0]->image_url;
      $data[$i]['content']['keywords'] = $article->contents[0]->keywords;
      $data[$i]['content']['sub_title'] = $article->contents[0]->sub_title;
      $data[$i]['content']['title'] = $article->contents[0]->title;

      $data[$i]['categories'] = $article->categories;
      $data[$i]['author'] = $article->author_id;
      $data[$i]['image'] = $article->image;
      $data[$i]['slug'] = $article->slug;
      $data[$i]['views'] = $article->views;
      $data[$i]['created_at'] = $article->created_at;

      $i++;
    }

    return $data;
  }
  /*
  * @params locale_id: the asked locale id | int, category: the asked category | Category Object
  * @return Article Object
  */
  public static function getArticlesByCategory($locale_id, $category)
  {
    return $article = $category->articleContents()->where('language', $locale_id)->where('published', 1)->with('article')->paginate(10);
  }
}
