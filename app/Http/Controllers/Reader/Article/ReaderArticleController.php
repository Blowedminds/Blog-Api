<?php

namespace App\Http\Controllers\Reader\Article;

use App\Category;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Article;

class ReaderArticleController extends Controller
{
    public function __construct()
    {
    }

    public function getArticle($locale, $slug)
    {
        $language_id = Language::slug($locale)->first()->id;

        $article = Article::slug($slug)->whereHasPublishedContent($language_id)
            ->withPublishedContent($language_id)
            ->with(['categories', 'availableLanguages', 'author' => function ($q) {
                $q->with('userData');
            }])
            ->firstOrFail()
            ->toArray();

        $article['author'] = [
            'name' => $article['author']['name'],
            'profile_image' => $article['author']['user_data']['profile_image'],
            'biography' => json_decode($article['author']['user_data']['biography'], true)[$locale],
        ];

        return response()->json($article);
    }

    public function getMostVieweds($locale)
    {
        $language_id = Language::slug($locale)->first()->id;

        $most_viewed = Article::whereHasPublishedContent($language_id)
            ->withPublishedContent($language_id)
            ->with(['categories'])
            ->take(10)
            ->orderBy('views', 'DESC')
            ->get();

        return response()->json($most_viewed, 200);
    }

    public function getLatests($locale)
    {
        $language_id = Language::slug($locale)->first()->id;

        $most_viewed = Article::whereHasPublishedContent($language_id)
            ->withPublishedContent($language_id)
            ->with(['categories'])
            ->take(10)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json($most_viewed, 200);
    }

    public function getArticlesByCategory($locale, $category_slug)
    {
        $category = Category::slug($category_slug)->firstOrFail();

        $language_id = Language::slug($locale)->firstOrFail()->id;

        $articles = $category->articles()
            ->whereHasPublishedContent($language_id)
            ->with(['contents' => function ($q) {
                $q->select('article_id', 'title');
            }])
            ->paginate(10);

        return response()->json($articles, 200);
    }

    public function getArticlesBySearch($locale)
    {
        $query = request()->input('q');

        $articles = Article::whereHas('contents', function ($q) use ($query) {
            $q->where('title', 'like', '%' . $query . '%')->where('language_id', $this->language->id);
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
