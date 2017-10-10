<?php
Route::group(['middleware' => 'web'], function () {
	Route::get('chat', 'Frutdev\Laravchat\Controllers\ChatController@getIndex');

	Route::get('messages', 'Frutdev\Laravchat\Controllers\ChatController@getMessages');
	Route::post('message', 'Frutdev\Laravchat\Controllers\ChatController@postMessage');
	Route::get('users', 'Frutdev\Laravchat\Controllers\ChatController@getUsers');
	Route::get('user', 'Frutdev\Laravchat\Controllers\ChatController@getCurrentUser');
	Route::get('threads', 'Frutdev\Laravchat\Controllers\ChatController@getThreads');
	Route::post('thread', 'Frutdev\Laravchat\Controllers\ChatController@postThread');
	Route::get('{thread}/messages', 'Frutdev\Laravchat\Controllers\ChatController@getThreadMessages');
	Route::post('{thread}/message', 'Frutdev\Laravchat\Controllers\ChatController@postThreadMessage');
});