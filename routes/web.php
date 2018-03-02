<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/threads','ThreadController@index');
Route::post('/threads','ThreadController@store')->middleware('confirm-email');
Route::get('/threads/create','ThreadController@create');
Route::get('/threads/{channel}/{thread}','ThreadController@show');
Route::delete('/threads/{channel}/{thread}','ThreadController@destroy');

Route::delete('/locked-thread/{thread}','LockedThreadController@destroy')->middleware('administrator')->name('locked-thread.destroy');
Route::post('/locked-thread/{thread}','LockedThreadController@store')->middleware('administrator')->name('locked-thread.store');
Route::post('/threads/{channel}/{thread}/replies','ReplyController@store');
Route::get('/threads/{channel}/{thread}/replies','ReplyController@index');
Route::patch('/replies/{reply}','ReplyController@update');
Route::delete('/replies/{reply}','ReplyController@destroy');
Route::post('/replies/{reply}/best','ReplyController@markBestReply');
Route::post('/replies/{reply}/favorite','FavoriteController@store');
Route::delete('/replies/{reply}/favorite','FavoriteController@destroy');
Route::post('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@destroy');
Route::get('/users/{notificationId}','UserNotificationController@destroy');
Route::get('/profiles/{user}','ProfileController@show');

Route::get('/register/confirm','Api\UserController@confirm');

Route::get('/api/users','Api\UserController@index');
Route::post('/api/users/{user}/avatar','Api\UserAvatarController@store');
Auth::routes();
