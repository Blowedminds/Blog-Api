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

        $i = 0;

        [$latest, $articles] = Article::whereHasPublishedContent($language->id)
            ->withPublishedContent($language->id)
            ->with(['categories', 'author'])
            ->take(15)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->partition(function($item) use(&$i) { return $i++ < 3;});

        $latest_big = collect($latest->shift());

//                dd($latest, $latest_big, $articles);
        return view('home')->with([
            'menus' => $this->getMenus(),
            'articles' => $articles->toArray(),
            'latest' => $latest->toArray(),
            'latest_big' => $latest_big->toArray()
        ]);
    }
}
