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
