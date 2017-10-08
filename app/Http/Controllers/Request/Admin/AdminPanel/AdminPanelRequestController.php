<?php

namespace App\Http\Controllers\Request\Admin\AdminPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;

use App\Menu;
use App\Category;
use App\Language;
use App\Role;
use App\MenuRole;

class AdminPanelRequestController extends Controller
{

  public function __construct()
  {

  }

  public function getMenus()
  {
      $menus = Menu::with(['menuRoles'])->get();
      //return response()->json($menus, 200);

      $data = []; $i = 0;

      foreach ($menus as $key => $menu) {
        $data['menus'][$i]['id'] = $menu->id;
        $data['menus'][$i]['menu_name'] = $menu->menu_name;
        $data['menus'][$i]['menu_parent'] = $menu->menu_parent;
        $data['menus'][$i]['menu_tooltip'] = $menu->menu_tooltip;
        $data['menus'][$i]['menu_url'] = $menu->menu_url;
        $data['menus'][$i]['menu_weight'] = $menu->menu_weight;
        $j = 0;

          foreach ($menu->menuRoles as $key => $role) {
            $data['menus'][$i]['menu_roles'][$j] = $role->role_id;
            $j++;
          }

        $i++;
      }

      $roles = Role::all();

      $i = 0;

      foreach ($roles as $key => $role) {
        $data['roles'][$i]['id'] = $role->id;
        $data['roles'][$i]['role_name'] = $role->role_name;
        $i++;
      }

      return response()->json($data, 200);
  }

  public function getCategories()
  {
    $categories = Category::all();

    $data = []; $i = 0;

    foreach ($categories as $key => $category) {
      $data[$i]['id'] = $category->id;
      $data[$i]['name'] = $category->name;
      $data[$i]['description'] = $category->description;
      $i++;
    }
    return response()->json($data, 200);
  }

  public function getLanguages()
  {
    $languages = Language::all();

    $data = []; $i = 0;

    foreach ($languages as $key => $language) {
      $data[$i]['id'] = $language->id;
      $data[$i]['name'] = $language->name;
      $data[$i]['slug'] = $language->slug;
      $i++;
    }

    return response()->json($data, 200);
  }

  public function postLanguage(Request $request)
  {
    $this->validate($request, [
      'id' => 'required',
      'name' => 'required',
      'slug' => 'required'
    ]);

    if(!$language = Language::find(intval($request->input('id')))) return;

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

    if($language = Language::where('slug', $request->input('slug'))->first()) return;

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

  public function postCategory(Request $request)
  {
    $this->validate($request, [
      'id' => 'required',
      'name' => 'required',
      'description' => 'required'
    ]);

    if(!$category = Category::find(intval($request->input('id')))) return;

    $category->name = $request->input('name');

    $category->description = $request->input('description');

    $category->save();

    return response()->json(['TEBRIKLER'], 200);
  }

  public function putCategory(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'description' => 'required'
    ]);

    $category = Category::create([
      'name' => $request->input('name'),
      'description' => $request->input('description')
    ]);

    return response()->json(['TEBRIKLER'], 200);
  }

  public function deleteCategory($id)
  {
    if (!$category = Category::find(intval($id))) return;

    $category->forceDelete();

    return response()->json(['TEBRIKLER'], 200);
  }

  public function postMenu(Request $request)
  {
    $this->validate($request, [
      'id' => 'required',
      'menu_name' => 'required',
      'menu_url' => 'required',
      'menu_roles' => 'required',
      'menu_tooltip' => 'required',
      'menu_weight' => 'required',
      'menu_parent' => 'required'
    ]);

    if(!$category = Menu::find(intval($request->input('id')))) return;

    MenuRole::where('menu_id', $request->input('id'))->forceDelete();

    foreach ($request->input('menu_roles') as $key => $value) {
      MenuRole::create([
        'menu_id' => $request->input('id'),
        'role_id' => $value['id']
      ]);
    }

    $category->menu_name = $request->input('menu_name');

    $category->menu_url = $request->input('menu_url');

    $category->menu_tooltip = $request->input('menu_tooltip');

    $category->menu_weight = intval($request->input('menu_weight'));

    $category->menu_parent = intval($request->input('menu_parent'));

    $category->save();

    return response()->json(['TEBRIKLER'], 200);
  }

  public function putMenu(Request $request)
  {
    $this->validate($request, [
      'menu_name' => 'required',
      'menu_url' => 'required',
      'menu_roles' => 'required',
      'menu_tooltip' => 'required',
      'menu_weight' => 'required',
      'menu_parent' => 'required'
    ]);

    $menu = Menu::create([
      'menu_name' => $request->input('menu_name'),
      'menu_url' => $request->input('menu_url'),
      'menu_tooltip' => $request->input('menu_tooltip'),
      'menu_weight' => $request->input('menu_weight'),
      'menu_parent' => $request->input('menu_parent'),
    ]);

    foreach ($request->input('menu_roles') as $key => $value) {
      MenuRole::create([
        'menu_id' => $menu->id,
        'role_id' => $value['id']
      ]);
    }

    return response()->json(['TEBRIKLER'], 200);
  }

  public function deleteMenu($id)
  {
    if (!$category = Menu::find(intval($id))) return;

    $category->forceDelete();

    return response()->json(['TEBRIKLER'], 200);
  }
}
