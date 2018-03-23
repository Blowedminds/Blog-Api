<?php

namespace App\Http\Controllers\Reader;

use App\Category;
use App\Http\Controllers\Controller;

use App\Role;
use App\Language;
use App\Image;

class ReaderController extends Controller
{
    public function __construct()
    {
    }

    public function getMenus($locale)
    {
        $menus = Role::find(3)->menus->map(function ($menu) use($locale) {
            return [
                'name' => json_decode($menu->name, true)[$locale],
                'tooltip' => json_decode($menu->tooltip, true)[$locale],
                'url' => $menu->url,
                'weight' => $menu->weight
            ];
        })->toArray();

        usort($menus, function ($a, $b) {
            return $a['weight'] - $b['weight'];
        });

        return response()->json($menus, 200);
    }

    public function getLanguages()
    {
        $languages = Language::all()->map(function ($language) {
            return [
                'name' => $language->name,
                'slug' => $language->slug
            ];
        });

        return response()->json($languages, 200);
    }

    public function getImage($image)
    {
        $not_found_response = ['header' => 'Hata', 'message' => 'Resmi bulamadık', 'state' => 'error'];

        if (!$query = Image::where('u_id', $image)->first()) {
            return response()->json($not_found_response);
        }

        if ($query->public == 0) {
            return response()->json($not_found_response);
        }

        return response()->file(storage_path('/app/albums/' . $query->u_id . '/' . $query->u_id . ".$query->type"), ['Content-Type' => 'image/' . $query->type]);
    }

    public function getCategories()
    {
        $categories = Category::all()->map(function ($category) {

            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'slug' => $category->slug
            ];
        });

        return response()->json($categories, 200);
    }

}
