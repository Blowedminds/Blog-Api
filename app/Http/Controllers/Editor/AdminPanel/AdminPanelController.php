<?php

namespace App\Http\Controllers\Editor\AdminPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Category;
use App\Language;
use App\Role;
use App\MenuRole;

class AdminPanelController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin', 'auth:api']);
    }

    public function getMenus()
    {
        $menus = Menu::with(['menuRoles'])->get()->map(function ($menu) {

            $menu_roles = $menu->menuRoles->map(function ($menu_role) {
                return ['id' => $menu_role->role_id];
            })->toArray();

            return [
                'id' => $menu->id,
                'name' => $this->fillEmptyLocalizedMenu(json_decode($menu->name, true) ?? []),
                'parent' => $menu->parent,
                'tooltip' => $this->fillEmptyLocalizedMenu(json_decode($menu->tooltip, true) ?? []),
                'url' => $menu->url,
                'weight' => $menu->weight,
                'roles' => $menu_roles
            ];
        })->toArray();

        usort($menus, function ($a, $b) {
            return $a['weight'] - $b['weight'];
        });

        $roles = Role::all()->map(function ($role) {

            return [
                'id' => $role->id,
                'name' => $role->name
            ];
        });

        return response()->json([
            'menus' => $menus,
            'roles' => $roles
        ], 200);
    }

    public function getCategories()
    {
        $categories = Category::all()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description
            ];
        });

        return response()->json($categories, 200);
    }

    public function getLanguages()
    {
        $languages = Language::all()->map(function ($language) {
            return [
                'id' => $language->id,
                'name' => $language->name,
                'slug' => $language->slug
            ];
        });

        return response()->json($languages, 200);
    }

    public function postLanguage(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'slug' => 'required'
        ]);

        if (!$language = Language::find(intval($request->input('id')))) return;

        $language->name = $request->input('name');

        $language->slug = $request->input('slug');

        $language->save();

        return response()->json(['TEBRIKLER'], 200);
    }

    public function putLanguage(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if ($language = Language::where('slug', $request->input('slug'))->first()) return;

        $language = Language::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug')
        ]);

        return response()->json(['TEBRIKLER'], 200);
    }

    public function deleteLanguage($id)
    {
        if (!$language = Language::find(intval($id))) return;

        $language->forceDelete();

        return response()->json(['TEBRIKLER'], 200);
    }

    public function postCategory($category_id)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required'
        ]);

        $category = Category::findOrFail($category_id);

        $category->name = request()->input('name');

        $category->description = request()->input('description');

        $category->slug = request()->input('slug');

        $category->save();

        return response()->json(['TEBRIKLER'], 200);
    }

    public function putCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required'
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'slug' => $request->input('slug')
        ]);

        return response()->json(['TEBRIKLER'], 200);
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->forceDelete();

        return response()->json(['TEBRIKLER'], 200);
    }

    public function postMenu()
    {
        $menuUpdateKeys = [
            'name' => 'required',
            'url' => 'required',
            'tooltip' => 'required',
            'weight' => 'required',
            'parent' => 'required'
        ];

        request()->validate(array_merge([
            'id' => 'required',
            'roles' => 'required'
        ], $menuUpdateKeys));

        request()->merge(['name' => json_encode($this->fillEmptyLocalizedMenu(request()->input('name')))]);
        request()->merge(['tooltip' => json_encode($this->fillEmptyLocalizedMenu(request()->input('tooltip')))]);

        $menu = Menu::findOrFail(request()->input('id'));

        foreach ($menuUpdateKeys as $key => $value) {

            $menu->{$key} = request()->input($key);
        }

        MenuRole::where('menu_id', request()->input('id'))->forceDelete();

        foreach (request()->input('roles') as $key => $value) {

            $role = Role::findOrFail($value['id']);

            MenuRole::create([
                'menu_id' => $menu->id,
                'role_id' => $role->id
            ]);
        }

        $menu->save();

        return response()->json([], 200);
    }

    public function putMenu(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'tooltip' => 'required',
            'weight' => 'required',
            'parent' => 'required'
        ]);

        request()->merge(['name' => json_encode($this->fillEmptyLocalizedMenu(request()->input('name')))]);
        request()->merge(['tooltip' => json_encode($this->fillEmptyLocalizedMenu(request()->input('tooltip')))]);

        $menu = Menu::create([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
            'tooltip' => $request->input('tooltip'),
            'weight' => $request->input('weight'),
            'parent' => $request->input('parent'),
        ]);

        if ($request->has('roles'))
            foreach ($request->input('roles') as $key => $value) {
                MenuRole::create([
                    'menu_id' => $menu->id,
                    'role_id' => $value['id']
                ]);
            }

        return response()->json([], 200);
    }

    public function deleteMenu($id)
    {
        Menu::findOrFail($id)->forceDelete();

        return response()->json(['TEBRIKLER'], 200);
    }

    private function fillEmptyLocalizedMenu($localized_menu_name)
    {
        $filled_menus = [];

        foreach (Language::all() as $language) {
            if (!array_key_exists($language->slug, $localized_menu_name) || !$localized_menu_name[$language->slug])
                $filled_menus[$language->slug] = '';
            else
                $filled_menus[$language->slug] = $localized_menu_name[$language->slug];
        }

        return $filled_menus;
    }

}
