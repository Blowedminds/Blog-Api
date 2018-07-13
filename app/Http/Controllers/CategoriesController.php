<?php

namespace App\Http\Controllers;

use App\Modules\Core\Category;

class CategoriesController extends Controller
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
        $categories = Category::all();

        return view('categories')->with([
            'menus' => $this->getMenus(),
            'categories' => $categories
        ]);
    }
}
