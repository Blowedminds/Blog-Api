<?php

namespace App\Http\Controllers;

use App\Modules\Core\Article;
use App\Modules\Core\Language;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class HomeController extends Controller
{
    use MenuTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $language = Language::slug(LaravelLocalization::getCurrentLocale())->firstOrFail();

        $articles = Article::whereHasPublishedContent($language->id)
            ->withPublishedContent($language->id)
            ->with('categories')
            ->paginate(3)
            ->toArray();

        return view('home')->with([
            'menus' => $this->getMenus(),
            'articles' => $articles
        ]);
    }
}
