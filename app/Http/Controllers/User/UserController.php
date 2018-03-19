<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

use App\Language;
use App\Http\Controllers\Api\MainApi as API;
use App\Http\Controllers\Api\AuthApi;
use App\Exceptions\InvalidInputException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function getUserInfo()
    {
        $user = auth()->user();

        return response()->json([
            'name' => $user->name,
            'user_id' => $user->user_id,
            'role_id' => $user->roles[0]->id
        ]);
    }

    public function getUserProfile()
    {
        $user = auth()->user();

        $user_data = $user->userData;

        $user_bio = json_decode($user_data->biography);

        $data['bio'] = Language::all('slug')->map(function ($language) use ($user_bio) {

            if ($user_bio) {
                $key = array_search($language->slug, array_column($user_bio, 'slug'));
            } else {
                $key = false;
            }

            return [
                'slug' => $language->slug,
                'bio' => $key !== false ? $user_bio[$key]->bio : null
            ];
        });

        $role = $user->roles()->first();

        $data['profile_image'] = $user_data->profile_image;

        $data['name'] = $user->name;

        $data['user_id'] = $user->user_id;

        $data['role_id'] = $role->id;

        $data['role_name'] = $role->role_name;

        return response()->json($data);
    }

    public function postUserProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'bio' => 'required'
        ]);

        if ($this->isValidBio($request->input('bio'))) {
            throw new InvalidInputException;
        }

        $user = auth()->user();

        $user->name = $request->input('name');

        $user_data = $user->userData;

        $user_data->biography = json_encode($request->input('bio'));

        $user_data->save();

        $user->save();

        return response()->json(['Tebrikler'], 200);
    }

    public function postUserProfileImage()
    {
        request()->validate([
            'file' => 'required|image|max:33554432',
        ]);

        $user_data = auth()->user()->userData;

        $file = request()->file('file');

        $extension = $file->extension();

        $u_id = uniqid('img_');

        $store_name = $u_id . "." . $extension;

        File::delete("images/author/" . $user_data->profile_image);

        $user_data->profile_image = $store_name;

        $user_data->save();

        $path = rtrim(app()->basePath('public/' . "images/author"), '/');

        request()->file('file')->move($path, $store_name);

        return response()->json(['TEBRIKLER'], 200);
    }

    public function getMenus($language_slug)
    {
        $menus = auth()->user()->role->menus()->orderBy('weight', 'DESC')->get()->map(function ($menu) use ($language_slug) {
            return [
                'name' => json_decode($menu->name, true)[$language_slug],
                'tooltip' => json_decode($menu->tooltip, true)[$language_slug],
                'url' => $menu->url,
                'weight' => $menu->weight
            ];
        })->toArray();

        return response()->json($menus, 200);
    }

    private function isValidBio($bio)
    {
        $is_valid = Language::all('slug')->reduce(function ($carry, $language) use ($bio) {

            return $carry && ($bio[$language->slug] ?? null);
        }, true);

        return (bool)$is_valid;
    }
}
