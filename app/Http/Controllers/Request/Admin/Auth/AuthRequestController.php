<?php
namespace App\Http\Controllers\Request\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi;

use App\Http\Controllers\Api\AuthApi;

class AuthRequestController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth', ['only' => ['logout']]);
  }

  public function login(Request $request)
  {
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    $login = self::_login($credentials);

    return response()->json($login['data'], $login['status']);
  }

  public function logout()
  {
    app('auth')->invalidate(app('auth')->getToken());

    return response()->json(true, 200);
  }

  public function register(Request $request)
  {
    $messages = [
      'name.required' => 'İsim gerekli, lütfen isminizi giriniz',
      'email.required' => 'E-posta adresi gerekli, lütfen e-posta adresi giriniz',
      'email.email' => 'E-posta adresiniz geçersiz, lütfen geçerli bir e-posta adresi giriniz',
      'email.unique' => 'Bu e-posta adresi zaten kullanılıyor',
      'password.required' => 'Şifre gerekli, lütfen şifrenizi giriniz',
      'password.min' => 'Şifreniz en az 6 karakterli olmalı',
      'password.confirmed' => 'Şifreleriniz uyuşmuyor, kontrol ediniz',
      'password_confirmation.required' => 'Şifre tekrarı gerekli'
    ];

    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required'
    ], $messages);

    $unique_id = uniqid('user');

    $email = $request->input('email');
    $name = $request->input('name');
    $password = $request->input('password');

    $user = new \App\User([
        'user_id' => $unique_id,
        'name' => $name,
        'email' => $email,
        'password' => app('hash')->make($password),
    ]);

    $user->save();

    $userRole = \App\UserData::create([
      'user_id' => $user->user_id,
      'name' => $name,
      'role_id' => 2,
      'profile_image' => 'DEFAULT_IMAGE',
      'biography' => "{'tr':'Buraya kendinizi anlatan kısa bir metin yazın!''}"
    ]);

    $credentials = $request->only('email', 'password');

    $login = self::_login($credentials);

    return response()->json($login['data'], $login['status']);
  }

  public function checkAuth()
  {
    if (!$this->_checkAuth())
      return response()->json(false, 200);

    return response()->json(true, 200);
  }

  private static function _login($credentials)
  {
    $data = [];

    try{
        if (!$token = app('auth')->attempt($credentials)){

            $data['data'] = ['error' => 'Invalid Credentials'];
            $data['status'] = 401;
            return $data;
        }
    }catch(JWTException $e) {

        $data['data'] = ['error' => 'Could not create a token'];
        $data['status'] = 500;
        return $data;
    }
    $data['data'] = ['token' => $token];
    $data['status'] = 200;
    return $data;
  }

  private function _checkAuth()
  {
    if (!AuthApi::authUser()) return false;

    return true;
  }
}
