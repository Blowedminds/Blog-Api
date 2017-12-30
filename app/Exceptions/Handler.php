<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Exceptions\CustomExceptions\RestrictedAreaException;
use App\Http\Controllers\Api\MainApi;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        RestrictedAreaException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        switch ($e) {
          case $e instanceof RestrictedAreaException:
            return MainApi::responseApi([
              'header' => 'Kısıtlı Erişim', 'message' => 'Bu sayfaya erişiminiz yok', 'state' => 'error'
            ], 422);
            break;
          case $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException:
            return MainApi::responseApi(['error' => 'Unauthorized'],401);
            break;
          case $e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException:
            return MainApi::responseApi(['error' => 'Unauthorized'],401);
            break;
          case $e instanceof \Tymon\JWTAuth\Exceptions\JWTException:
            return MainApi::responseApi(['error' => 'Unauthorized'],401);
            break;
          case $e instanceof \Illuminate\Auth\AuthenticationException:
            return MainApi::responseApi(['error' => 'Unauthorized'],401);
            break;
          default:

            break;
        }

        return parent::render($request, $e);
    }
}
