<?php

namespace App\Http\Controllers;

use App\Modules\Core\Category;
use App\Modules\Core\Language;
use Illuminate\Support\Facades\Cache;

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
        $locale = Language::first();


        return view('home')->with([
            'menus' => $this->getMenus(),
        ]);
    }
}
