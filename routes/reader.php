<?php

Route::group(['prefix' => '{locale}'], function() {

  Route::get('menus', 'ReaderController@getMenus');

  Route::get('home-data', 'ReaderController@getHomeData');

  Route::get('languages', 'ReaderController@getLanguages');

  Route::get('about-me', 'ReaderController@getAboutMe');

  Route::get('categories', 'ReaderController@getCategories');

  Route::group(['prefix' => 'article'], function() {

    Route::get('article-single/{article_slug}', 'Article\ReaderArticleController@getArticleSingle');

    Route::get('most-viewed', 'Article\ReaderArticleController@getMostVieweds');

    Route::get('latest', 'Article\ReaderArticleController@getLatests');

    Route::get('category/{category_slug}', 'Article\ReaderArticleController@getArticlesByCategory');

    Route::get('search', 'Article\ReaderArticleController@getArticlesBySearch');

    Route::get('archive', 'Article\ReaderArticleController@getArticlesByArchive');
  });

});
