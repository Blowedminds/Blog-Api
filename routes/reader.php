<?php

Route::group(['prefix' => '{locale}'], function() {

  Route::get('menus', 'ReaderRequestController@getMenus');

  Route::get('home-data', 'ReaderRequestController@getHomeData');

  Route::get('languages', 'ReaderRequestController@getLanguages');

  Route::get('about-me', 'ReaderRequestController@getAboutMe');

  Route::get('categories', 'ReaderRequestController@getCategories');

  Route::group(['prefix' => 'article'], function() {

    Route::get('article-single/{article_slug}', 'Article\ReaderArticleController@getArticleSingle');

    Route::get('most-viewed', 'Article\ReaderArticleController@getMostVieweds');

    Route::get('latest', 'Article\ReaderArticleController@getLatests');

    Route::get('category/{category_slug}', 'Article\ReaderArticleController@getArticlesByCategory');

    Route::get('search', 'Article\ReaderArticleController@getArticlesBySearch');

    Route::get('archive', 'Article\ReaderArticleController@getArticlesByArchive');
  });

});
