<?php

Route::get('rooms', 'RoomController@getRooms');
Route::get('{article_slug}/messages', 'RoomController@getMessages');
Route::put('{article_slug}/message', 'RoomController@putMessage');