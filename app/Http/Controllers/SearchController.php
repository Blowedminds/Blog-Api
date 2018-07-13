<?php

namespace App\Http\Controllers;


use App\Modules\Core\Article;
use App\Modules\Core\Language;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SearchController
{
    use MenuTrait;

    public function getResults()
    {
        $language_id = Language::slug(LaravelLocalization::getCurrentLocale())->firstOrFail()->id;

        $query = request()->input('q');

        $articles = Article::whereHasPublishedContent($language_id)
            ->withPublishedContent($language_id)
            ->with(['categories', 'author'])
            ->whereHas('contents', function ($q) use ($query, $language_id) {
                $q->where('title', 'like', '%' . $query . '%');
            })
            ->paginate(10)
            ->toArray();

        return view('archive')->with([
            'menus' => $this->getMenus(),
            'title' => 'Search Results for "'. $query . '"',
            'articles' => $articles
        ]);
    }
}