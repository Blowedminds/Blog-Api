<?php

Route::get('articles', 'Article\ArticleController@getArticles');

Route::get('trashed-articles', 'Article\ArticleController@getTrashedArticles');

Route::group(['prefix' => 'article'], function () {

    Route::put('', 'Article\ArticleController@putArticle');

    Route::post('restore/{article_id}', 'Article\ArticleController@postRestore');

    Route::get('{article_slug}', 'Article\ArticleController@getArticle');

    Route::post('{article_id}', 'Article\ArticleController@postArticle');

    Route::delete('{article_id}', 'Article\ArticleController@deleteArticle');

    Route::get('content/{article_slug}/{language_slug}', 'Article\ArticleController@getArticleContent');

    //TODO: Convert this also to content/article_id/language_slug
    Route::post('content/{article_id}', 'Article\ArticleController@postArticleContent');

    Route::put('content/{article_id}', 'Article\ArticleController@putArticleContent');

    Route::delete('force-delete/{article_id}', 'Article\ArticleController@deleteForceDelete');

    Route::get('permission/{article_id}', 'Article\ArticleController@getPermission');

    Route::put('permission/{article_id}', 'Article\ArticleController@putPermission');
});

Route::group(['prefix' => 'panel'], function () {

    Route::get('users', 'AdminPanel\AdminPanelController@getUsers');

    Route::get('user/{user_id}', 'AdminPanel\AdminPanelController@getUser');

    Route::post('user/{user_id}', 'AdminPanel\AdminPanelController@postUser');

    Route::delete('user/{user_id}', 'AdminPanel\AdminPanelController@deleteUser');

    Route::post('users', 'AdminPanel\AdminPanelController@postUser');

    Route::put('users', 'AdminPanel\AdminPanelController@putUser');

    Route::get('menus', 'AdminPanel\AdminPanelController@getMenus');

    Route::post('menus', 'AdminPanel\AdminPanelController@postMenu');

    Route::put('menus', 'AdminPanel\AdminPanelController@putMenu');

    Route::delete('menus/{id}', 'AdminPanel\AdminPanelController@deleteMenu');

    Route::get('categories', 'AdminPanel\AdminPanelController@getCategories');

    Route::post('categories/{category_id}', 'AdminPanel\AdminPanelController@postCategory');

    Route::put('categories', 'AdminPanel\AdminPanelController@putCategory');

    Route::delete('categories/{id}', 'AdminPanel\AdminPanelController@deleteCategory');

    Route::get('languages', 'AdminPanel\AdminPanelController@getLanguages');

    Route::post('languages', 'AdminPanel\AdminPanelController@postLanguage');

    Route::put('languages', 'AdminPanel\AdminPanelController@putLanguage');

    Route::delete('languages/{id}', 'AdminPanel\AdminPanelController@deleteLanguage');

    Route::get('roles', 'AdminPanel\AdminPanelController@getRoles');
});
