<?php

namespace App\Http\Controllers;

use App\Modules\Core\Article;
use App\Modules\Core\Language;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ArticleController extends Controller
{
    use MenuTrait;

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index($article_slug)
    {
        $language_id = Language::slug(LaravelLocalization::getCurrentLocale())->firstOrFail()->id;

        $article = Article::slug($article_slug)
            ->whereHasPublishedContent($language_id)
            ->withPublishedContent($language_id)
            ->with(['categories', 'availableLanguages', 'author' => function ($q) {
                $q->with('userData');
            }])
            ->firstOrFail();

        $article->increment('views');

        return view('article')->with(['article' => $article, 'menus' => $this->getMenus()]);
    }
}
