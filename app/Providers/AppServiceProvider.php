<?php

namespace App\Providers;

use App\Modules\Core\Article;
use App\Modules\Article\Observers\ArticleObserver;
use App\Modules\User\Observers\UserObserver;
use App\Modules\Core\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(ArticleObserver::class);
        User::observe(UserObserver::class);

        Blade::directive('localizeURL', function($expression) {
           return
               "<?php echo LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), $expression) ?>";
        });

        Blade::directive('datetime', function($expression) {
            return
                "<?php echo (new DateTime($expression))->format('d-m-Y H:i'); ?>";
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
