<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\Api\AuthApi;
use App\Exceptions\CustomExceptions\RestrictedAreaException;

class Admin
{
  public function handle($request, Closure $next, $guard = null)
  {
      if (count(AuthApi::authUser()->rolesByRoleId(1)->get()) == 0) {
        
          throw new RestrictedAreaException();
      }

      return $next($request);
  }
}
