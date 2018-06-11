<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::get('/test', function () {
        return LaravelLocalization::getCurrentLocale();
    });
    Route::get('/', 'HomeController@index')->name('home');

//    Route::get('/contact-us', 'ContactUsController@index')->name('contact-us');

    Route::get('/about-us', 'AboutUsController@index')->name('about-us');

//    Route::get('/faq', 'FAQController@index')->name('faq');

    Route::get('/blog', function () {
        return 'Under Construction <a href="/">Back to Main Page</a>';
    })->name('blog');

//    Route::get('/services/{service?}', 'ServiceController@index')->name('services');

    Route::get('/articles/{article_slug}', 'ArticleController@index');

    Route::get('/categories', 'CategoriesController@index');
    Route::get('/category/{category_slug}', 'ArchiveController@category');
});