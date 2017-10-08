<?php

$app->group(['prefix' => 'auth'], function() use($app){

  $app->put('register', 'Auth\AuthRequestController@register');

  $app->post('login', 'Auth\AuthRequestController@login');

  $app->get('logout', 'Auth\AuthRequestController@logout');

  $app->get('check', 'Auth\AuthRequestController@checkAuth');
});

$app->get('dashboard', function(){return response()->json(null, 200);});

$app->get('menus', 'AdminRequestController@getMenus');

$app->group(['prefix' => 'user'], function() use($app) {

  $app->get('info', 'User\UserRequestController@getUserInfo');
});

$app->group(['prefix' => 'article'], function() use($app) {

  $app->get('articles', 'Article\ArticleRequestController@getArticles');

  $app->get('properties', 'Article\ArticleRequestController@getProperties');

  $app->post('article', 'Article\ArticleRequestController@postArticle');

  $app->post('content', 'Article\ArticleRequestController@postContent');

  $app->put('content', 'Article\ArticleRequestController@putContent');

  $app->put('article', 'Article\ArticleRequestController@putArticle');

  $app->delete('article/{article_id}', 'Article\ArticleRequestController@deleteArticle');

  $app->get('trash', 'Article\ArticleRequestController@getTrash');

  $app->post('restore', 'Article\ArticleRequestController@postRestore');

  $app->post('force-delete', 'Article\ArticleRequestController@postForceDelete');

  $app->get('permission/{article_id}', 'Article\ArticleRequestController@getPermission');

  $app->put('permission/{article_id}', 'Article\ArticleRequestController@putPermission');
});

$app->group(['prefix' => 'panel'], function() use($app){

  $app->get('menus', 'AdminPanel\AdminPanelRequestController@getMenus');

  $app->post('menus', 'AdminPanel\AdminPanelRequestController@postMenu');

  $app->put('menus', 'AdminPanel\AdminPanelRequestController@putMenu');

  $app->delete('menus/{id}', 'AdminPanel\AdminPanelRequestController@deleteMenu');

  $app->get('categories', 'AdminPanel\AdminPanelRequestController@getCategories');

  $app->post('categories', 'AdminPanel\AdminPanelRequestController@postCategory');

  $app->put('categories', 'AdminPanel\AdminPanelRequestController@putCategory');

  $app->delete('categories/{id}', 'AdminPanel\AdminPanelRequestController@deleteCategory');

  $app->get('languages', 'AdminPanel\AdminPanelRequestController@getLanguages');

  $app->post('languages', 'AdminPanel\AdminPanelRequestController@postLanguage');

  $app->put('languages', 'AdminPanel\AdminPanelRequestController@putLanguage');

  $app->delete('languages/{id}', 'AdminPanel\AdminPanelRequestController@deleteLanguage');
});
