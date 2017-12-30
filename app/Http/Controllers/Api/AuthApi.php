<?php
namespace App\Http\Controllers\Api;

class AuthApi
{
  public static function authUser()
  {
    try {

        if (! $user = app('auth')->authenticate()) {
            return false;
        }

      }
      catch(object $e){

      }
      //  catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
      //
      //     return false;
      //
      // } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
      //
      //     return false;
      //
      // } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
      //
      //     return false;
      //
      // } catch (\Illuminate\Auth\AuthenticationException $e) {
      //
      //     return false;
      //
      // }
    // the token is valid and we have found the user via the sub claim
    return $user;
  }
}
