<?php

Route::get('global-data', 'EditorController@getGlobalData');

Route::group(['prefix' => 'article'], function() {

  Route::get('articles', 'Article\ArticleController@getArticles');

  Route::get('properties', 'Article\ArticleController@getProperties');

  Route::post('article', 'Article\ArticleController@postArticle');

  Route::post('content', 'Article\ArticleController@postContent');

  Route::put('content', 'Article\ArticleController@putContent');

  Route::put('article', 'Article\ArticleController@putArticle');

  Route::delete('article/{article_id}', 'Article\ArticleController@deleteArticle');

  Route::get('trash', 'Article\ArticleController@getTrash');

  Route::post('restore', 'Article\ArticleController@postRestore');

  Route::post('force-delete', 'Article\ArticleController@postForceDelete');

  Route::get('permission/{article_id}', 'Article\ArticleController@getPermission');

  Route::put('permission/{article_id}', 'Article\ArticleController@putPermission');
});

Route::group(['prefix' => 'panel'], function() {

  Route::get('menus', 'AdminPanel\AdminPanelController@getMenus');

  Route::post('menus', 'AdminPanel\AdminPanelController@postMenu');

  Route::put('menus', 'AdminPanel\AdminPanelController@putMenu');

  Route::delete('menus/{id}', 'AdminPanel\AdminPanelController@deleteMenu');

  Route::get('categories', 'AdminPanel\AdminPanelController@getCategories');

  Route::post('categories', 'AdminPanel\AdminPanelController@postCategory');

  Route::put('categories', 'AdminPanel\AdminPanelController@putCategory');

  Route::delete('categories/{id}', 'AdminPanel\AdminPanelController@deleteCategory');

  Route::get('languages', 'AdminPanel\AdminPanelController@getLanguages');

  Route::post('languages', 'AdminPanel\AdminPanelController@postLanguage');

  Route::put('languages', 'AdminPanel\AdminPanelController@putLanguage');

  Route::delete('languages/{id}', 'AdminPanel\AdminPanelController@deleteLanguage');
});
