<?php

$app->get('images', 'ImageRequestController@getImages');

$app->get('image/{image}', 'ImageRequestController@getImage');

$app->post('image', 'ImageRequestController@postImage');

$app->get('edit/{image}', 'ImageRequestController@getEdit');

$app->put('edit/{image}', 'ImageRequestController@putEdit');

$app->delete('image/{image}', 'ImageRequestController@deleteImage');

$app->get('thumb/{image}', 'ImageRequestController@getThumb');
