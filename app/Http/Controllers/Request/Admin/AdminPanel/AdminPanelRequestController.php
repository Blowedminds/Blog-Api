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
    $this->middleware('admin');
  }

  public function getMenus()
  {
    $menus = Menu::with(['menuRoles'])->get();
    //return response()->json($menus, 200);

    $data = []; $i = 0;

    foreach ($menus as $key => $menu) {
      $data['menus'][$i]['id'] = $menu->id;
      $data['menus'][$i]['name'] = $menu->name;
      $data['menus'][$i]['parent'] = $menu->parent;
      $data['menus'][$i]['tooltip'] = $menu->tooltip;
      $data['menus'][$i]['url'] = $menu->url;
      $data['menus'][$i]['weight'] = $menu->weight;
      $j = 0;

        foreach ($menu->menuRoles as $key => $role) {
          $data['menus'][$i]['roles'][$j] = $role->role_id;
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
      'name' => 'required',
      'url' => 'required',
      //'roles' => 'required',
      'tooltip' => 'required',
      'weight' => 'required',
      'parent' => 'required'
    ]);

    if(!$category = Menu::find(intval($request->input('id')))) return;

    MenuRole::where('id', $request->input('id'))->forceDelete();

    if($request->has('roles'))
      foreach ($request->input('roles') as $key => $value) {
        MenuRole::create([
          'menu_id' => $request->input('id'),
          'role_id' => $value['id']
        ]);
      }

    $category->name = $request->input('name');

    $category->url = $request->input('url');

    $category->tooltip = $request->input('tooltip');

    $category->weight = intval($request->input('weight'));

    $category->parent = intval($request->input('parent'));

    $category->save();

    return response()->json(['TEBRIKLER'], 200);
  }

  public function putMenu(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'url' => 'required',
      //'roles' => 'required',
      'tooltip' => 'required',
      'weight' => 'required',
      'parent' => 'required'
    ]);

    $menu = Menu::create([
      'name' => $request->input('name'),
      'url' => $request->input('url'),
      'tooltip' => $request->input('tooltip'),
      'weight' => $request->input('weight'),
      'parent' => $request->input('parent'),
    ]);

    if($request->has('roles'))
      foreach ($request->input('roles') as $key => $value) {
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
