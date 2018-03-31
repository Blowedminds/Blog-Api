<?php

Route::get('languages', 'ReaderController@getLanguages');

Route::get('categories', 'ReaderController@getCategories');

Route::group(['prefix' => '{locale}'], function () {

    Route::get('menus', 'ReaderController@getMenus');

    Route::get('article/{article_slug}', 'Article\ReaderArticleController@getArticle');

//    Route::get( 'most-viewed', 'Article\ReaderArticleController@getMostVieweds');
//
//    Route::get('latest', 'Article\ReaderArticleController@getLatests');

    Route::get('sections', 'Article\ReaderArticleController@getSections');

    Route::get('category/{category_slug}', 'Article\ReaderArticleController@getArticlesByCategory');

    Route::get('search', 'Article\ReaderArticleController@getArticlesBySearch');

    Route::get('archive', 'Article\ReaderArticleController@getArticlesByArchive');
});
