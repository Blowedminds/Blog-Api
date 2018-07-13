<?php
namespace App\Http\Controllers;

use App\Modules\Core\Article;
use App\Modules\Core\Language;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AboutUsController extends Controller
{
    use MenuTrait;
    public function __construct()
    {
        $this->middleware('web');
    }
    public function index()
    {
        $language_id = Language::slug(LaravelLocalization::getCurrentLocale())->first()->id;
        $article = Article::slug('about-us')
            ->whereHasContent($language_id, false)
            ->withContent($language_id, false)
            ->firstOrFail();

        return view('about-us')->with(['article' => $article,'menus' => $this->getMenus()]);
    }
}