<?php

$app->group(['prefix' => '{locale}'], function() use ($app) {

  $app->get('menus', 'PublicRequestController@getMenus');

  $app->get('home-data', 'PublicRequestController@getHomeData');

  $app->get('languages', 'PublicRequestController@getLanguages');

  $app->get('about-me', 'PublicRequestController@getAboutMe');

  $app->get('categories', 'PublicRequestController@getCategories');

  $app->group(['prefix' => 'article'], function () use($app) {

    $app->get('article-single/{article_slug}', 'Article\PublicArticleController@getArticleSingle');

    $app->get('most-viewed', 'Article\PublicArticleController@getMostVieweds');

    $app->get('latest', 'Article\PublicArticleController@getLatests');

    $app->get('category/{category_slug}', 'Article\PublicArticleController@getArticlesByCategory');

    $app->get('search', 'Article\PublicArticleController@getArticlesBySearch');

    $app->get('archive', 'Article\PublicArticleController@getArticlesByArchive');
  });

});
