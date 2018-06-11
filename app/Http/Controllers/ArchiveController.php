<?php

namespace App\Http\Controllers;

use App\Modules\Core\Category;
use App\Modules\Core\Language;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ArchiveController extends Controller
{
    use MenuTrait;

    public function __construct()
    {
        $this->middleware('web');
    }

    public function category($category_slug)
    {
        $language = Language::slug(LaravelLocalization::getCurrentLocale())->firstOrFail();
        $category = Category::slug($category_slug)->firstOrFail();

        $articles = $category->articles()
            ->whereHasPublishedContent($language->id)
            ->withPublishedContent($language->id)
            ->with(['categories', 'author'])
            ->paginate(1)
            ->toArray();

        return view('archive')->with([
            'menus' => $this->getMenus(),
            'title' => $category->name,
            'articles' => $articles
        ]);
    }

    public function index($locale, $category_slug)
    {

    }
}
