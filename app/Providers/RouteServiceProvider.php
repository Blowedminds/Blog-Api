<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $moduleNamespace = 'App\Modules';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapReaderRoutes();

        $this->mapImageRoutes();

        $this->mapDiscussRoutes();

        $this->mapAuthRoutes();

        $this->mapAdminRoutes();

        $this->mapArticleRoutes();

        $this->mapUserRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapReaderRoutes()
    {
        Route::prefix('reader')
            ->middleware('api')
            ->namespace($this->namespace . "\Reader")
            ->group(base_path('routes/reader.php'));
    }

    protected function mapImageRoutes()
    {
        Route::prefix('image')
            ->middleware('api')
            ->namespace($this->moduleNamespace . "\Image\Http\Controllers")
            ->group(base_path('app/Modules/Image/Http/image.php'));
    }

    protected function mapDiscussRoutes()
    {
        Route::prefix('discuss')
            ->middleware('api')
            ->namespace($this->moduleNamespace . "\Discuss\Http\Controllers")
            ->group(base_path('app/Modules/Discuss/Http/discuss.php'));
    }

    protected function mapAuthRoutes()
    {
        Route::prefix('auth')
            ->middleware('api')
            ->namespace($this->moduleNamespace . "\Auth\Http\Controllers")
            ->group(base_path('app/Modules/Auth/Http/auth.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware('api')
            ->namespace($this->moduleNamespace . "\Editor\Admin\Http\Controllers")
            ->group(base_path('app/Modules/Editor/Admin/Http/admin.php'));
    }

    protected function mapArticleRoutes()
    {
        Route::prefix('article')
            ->middleware('api')
            ->namespace($this->moduleNamespace . '\Editor\Article\Http\Controllers')
            ->group(base_path('app/Modules/Editor/Article/Http/article.php'));
    }

    protected function mapUserRoutes()
    {
        Route::prefix('user')
            ->middleware('api')
            ->namespace($this->moduleNamespace . "\User\Http\Controllers")
            ->group(base_path('app/Modules/User/Http/user.php'));
    }
}
