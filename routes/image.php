<?php

Route::get('images', 'ImageRequestController@getImages');

Route::get('image/{image}', 'ImageRequestController@getImage');

Route::post('image', 'ImageRequestController@postImage');

Route::get('edit/{image}', 'ImageRequestController@getEdit');

Route::put('edit/{image}', 'ImageRequestController@putEdit');

Route::delete('image/{image}', 'ImageRequestController@deleteImage');

Route::get('thumb/{image}', 'ImageRequestController@getThumb');
