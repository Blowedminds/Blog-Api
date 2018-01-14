<?php

Route::get('global-data', 'EditorRequestController@getGlobalData');

Route::group(['prefix' => 'auth'], function()  {

  Route::put('register', 'Auth\AuthRequestController@register');

  Route::post('login', 'Auth\AuthRequestController@login');

  Route::get('logout', 'Auth\AuthRequestController@logout');

  Route::get('check', 'Auth\AuthRequestController@checkAuth');
});

Route::group(['prefix' => 'user'], function() {

  Route::get('info', 'User\UserRequestController@getUserInfo');

  Route::get('profile', 'User\UserRequestController@getUserProfile');

  Route::post('profile', 'User\UserRequestController@postUserProfile');

  Route::post('profile-image', 'User\UserRequestController@postUserProfileImage');

  Route::get('menus', 'User\UserRequestController@getMenus');

  Route::get('dashboard', function(){return response()->json(null, 200);});
});

Route::group(['prefix' => 'article'], function() {

  Route::get('articles', 'Article\ArticleRequestController@getArticles');

  Route::get('properties', 'Article\ArticleRequestController@getProperties');

  Route::post('article', 'Article\ArticleRequestController@postArticle');

  Route::post('content', 'Article\ArticleRequestController@postContent');

  Route::put('content', 'Article\ArticleRequestController@putContent');

  Route::put('article', 'Article\ArticleRequestController@putArticle');

  Route::delete('article/{article_id}', 'Article\ArticleRequestController@deleteArticle');

  Route::get('trash', 'Article\ArticleRequestController@getTrash');

  Route::post('restore', 'Article\ArticleRequestController@postRestore');

  Route::post('force-delete', 'Article\ArticleRequestController@postForceDelete');

  Route::get('permission/{article_id}', 'Article\ArticleRequestController@getPermission');

  Route::put('permission/{article_id}', 'Article\ArticleRequestController@putPermission');
});

Route::group(['prefix' => 'panel'], function() {

  Route::get('menus', 'AdminPanel\AdminPanelRequestController@getMenus');

  Route::post('menus', 'AdminPanel\AdminPanelRequestController@postMenu');

  Route::put('menus', 'AdminPanel\AdminPanelRequestController@putMenu');

  Route::delete('menus/{id}', 'AdminPanel\AdminPanelRequestController@deleteMenu');

  Route::get('categories', 'AdminPanel\AdminPanelRequestController@getCategories');

  Route::post('categories', 'AdminPanel\AdminPanelRequestController@postCategory');

  Route::put('categories', 'AdminPanel\AdminPanelRequestController@putCategory');

  Route::delete('categories/{id}', 'AdminPanel\AdminPanelRequestController@deleteCategory');

  Route::get('languages', 'AdminPanel\AdminPanelRequestController@getLanguages');

  Route::post('languages', 'AdminPanel\AdminPanelRequestController@postLanguage');

  Route::put('languages', 'AdminPanel\AdminPanelRequestController@putLanguage');

  Route::delete('languages/{id}', 'AdminPanel\AdminPanelRequestController@deleteLanguage');
});
