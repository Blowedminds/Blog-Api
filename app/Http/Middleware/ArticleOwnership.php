<?php

namespace App\Http\Middleware;

use App\Exceptions\RestrictedAreaException;
use Closure;

class ArticleOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if($user->permission('article-ownership')->count() < 1) {
            throw new RestrictedAreaException();
        }

        return $next($request);
    }
}
