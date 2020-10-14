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
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::get('/', 'SectionsController@index');
Route::get('settings', 'WordsController@index');
Route::resource('sections', 'SectionsController');
Route::resource('chats', 'ChatsController');
Route::resource('words', 'WordsController');
Route::resource('section_trees', 'SectionTreesController');



Route::get('/sections/future', 'SectionsController@future_show')->name('section.future_show');

Route::get('/result/ajax', 'ChatsController@getData');
Route::get('/words/result/ajax/word/chat/{id}', 'SettingChatsController@getData');
Route::get('/chat/reply/{id}', 'ChatsController@getReply');

Route::group(['prefix' => '/words/{id}'], function () {
    Route::resource('settings', 'SettingsController');
});
Route::group(['prefix' => '/words/chat/{id}'], function () {
    Route::resource('settingchats', 'SettingChatsController');
});

Route::post('/chat/show/{id}', 'ChatsController@show')->name('chat.show');
Route::group(['middleware' => ['auth']], function () {
    Route::post('/sections/{id}', 'SectionsController@store2')->name('section.store2');
    Route::post('/setting/nice/{id}', 'SettingNiceController@store')->name('setting.nice');
    Route::delete('/setting/unnice/{id}', 'SettingNiceController@destroy')->name('setting.unnice');
    Route::post('/section/nice/{id}', 'SectionNiceController@store')->name('section.nice');
    Route::post('/chat/reply/create/{id}/store', 'ChatReplyController@store')->name('reply.store');
    Route::post('/chat/reply/create/{id}', 'ChatReplyController@create')->name('reply.create');
    Route::delete('/section/unnice/{id}', 'SectionNiceController@destroy')->name('section.unnice');
});
