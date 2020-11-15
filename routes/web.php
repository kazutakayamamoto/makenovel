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
Auth::routes(['verify' => true]);
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::get('/', 'SectionsController@mainpage');
Route::get('/{bookid}', 'SectionsController@index')->name('section.main');
Route::get('/makenovel/rule', 'SectionsController@rule')->name('makenovel.rule');
Route::get('/makenovel/rule/privacy', 'SectionsController@privacy')->name('rule.privacy');


Route::group(['prefix' => '/{bookid}'], function () {
    Route::get('settings', 'WordsController@index');
    
    Route::get('/sections/future/', 'SectionsController@future_show')->name('section.futuresh');
    
    Route::resource('sections', 'SectionsController',['only' => ['index', 'show']]);
    Route::resource('chats', 'ChatsController',['only' => ['index', 'show']]);
    
    Route::resource('words', 'WordsController',['only' => ['index', 'show']]);
    Route::resource('section_trees', 'SectionTreesController',['only' => ['index', 'show']]);
    
    
    
    
    
    Route::post('/setting/chat/reply/{id}', 'SettingChatsController@show')->name('settingchatreply.show');
    
    Route::get('/section_tree/{id}', 'SectionTreesController@show')->name('section_trees.show');
    Route::post('/chat/show/{id}', 'ChatsController@show')->name('chat.show');
    Route::get('/result/ajax', 'ChatsController@getData');
});

    Route::get('/words/result/ajax/word/chat/{id}', 'SettingChatsController@getData');
    Route::get('/chat/reply/{id}', 'ChatsController@getReply');
    Route::get('/word/chat/reply/{id}', 'SettingChatsController@getReply');

Route::group(['middleware' => ['auth','verified']], function () {
    Route::group(['prefix' => '/{bookid}'], function () {
        
        Route::post('/sections/{id}', 'SectionsController@store2')->name('section.store2');
        Route::post('/section_tree/section_number/{id}/store', 'SectionTreesController@store2')->name('section_trees.store2');
        
        Route::post('/setting/nice/{id}', 'SettingNiceController@store')->name('setting.nice');
        Route::delete('/setting/unnice/{id}', 'SettingNiceController@destroy')->name('setting.unnice');
        Route::post('/section_tree/nice/{id}', 'SectionTreeNicesController@store')->name('section_tree.nice');
        Route::delete('/section_tree/unnice/{id}', 'SectionTreeNicesController@destroy')->name('section_tree.unnice');
        Route::post('/section/nice/{id}', 'SectionNiceController@store')->name('section.nice');
        Route::post('/chat/reply/create/{id}/store', 'ChatReplyController@store')->name('reply.store');
        Route::post('/chat/reply/create/{id}', 'ChatReplyController@create')->name('reply.create');
        
        Route::post('/setting/chat/reply/{word_id}/chat/reply/create/{id}/store', 'SettingChatReplyController@store')->name('settingchatsreply.store');
        Route::post('/setting/chat/reply/{word_id}/chat/reply/create/{id}', 'SettingChatReplyController@create')->name('settingchatsreply.create');
        
        Route::delete('/section/unnice/{id}', 'SectionNiceController@destroy')->name('section.unnice');
    
        Route::group(['prefix' => '/words/{id}'], function () {
            Route::resource('settings', 'SettingsController');
        });
        Route::group(['prefix' => '/words/chat/{id}'], function () {
            Route::resource('settingchats', 'SettingChatsController');
        });
        Route::post('/sections/future/store', 'SectionsController@future_store')->name('section.futurest');
        Route::resource('sections', 'SectionsController',['only' => ['store']]);
        Route::resource('chats', 'ChatsController',['only' => ['store']]);
        Route::resource('words', 'WordsController',['only' => ['store']]);
        Route::post('/word/destroy/{id}', 'WordsController@destroy')->name('words.destroy');
        Route::post('/word/update/{id}', 'WordsController@update')->name('words.update');
        Route::resource('section_trees', 'SectionTreesController',['only' =>'store']);
    });    
    Route::resource('books', 'BooksController');
    Route::get('/userpage/index', 'UsersController@index')->name('users.index');
    Route::get('/userpage/edit/book/{id}', 'UsersController@edit')->name('book.edit');    
    Route::post('/user/blacklist/{id}', 'BlackListsController@edit')->name('user.blacklist');
    Route::post('/user/blacklist/destroy/{id}', 'BlackListsController@destroy')->name('destroy.blacklist');    
    
    
    
    
    // Route::post('/sections/{id}', 'SectionsController@store2')->name('section.store2');
    // Route::post('/section_tree/section_number/{id}/store', 'SectionTreesController@store2')->name('section_trees.store2');
    
    // Route::post('/setting/nice/{id}', 'SettingNiceController@store')->name('setting.nice');
    // Route::delete('/setting/unnice/{id}', 'SettingNiceController@destroy')->name('setting.unnice');
    // Route::post('/section_tree/nice/{id}', 'SectionTreeNicesController@store')->name('section_tree.nice');
    // Route::delete('/section_tree/unnice/{id}', 'SectionTreeNicesController@destroy')->name('section_tree.unnice');
    // Route::post('/section/nice/{id}', 'SectionNiceController@store')->name('section.nice');
    // Route::post('/chat/reply/create/{id}/store', 'ChatReplyController@store')->name('reply.store');
    // Route::post('/chat/reply/create/{id}', 'ChatReplyController@create')->name('reply.create');
    
    // Route::post('/setting/chat/reply/{word_id}/chat/reply/create/{id}/store', 'SettingChatReplyController@store')->name('settingchatsreply.store');
    // Route::post('/setting/chat/reply/{word_id}/chat/reply/create/{id}', 'SettingChatReplyController@create')->name('settingchatsreply.create');
    
    // Route::delete('/section/unnice/{id}', 'SectionNiceController@destroy')->name('section.unnice');

    // Route::group(['prefix' => '/words/{id}'], function () {
    //     Route::resource('settings', 'SettingsController');
    // });
    // Route::group(['prefix' => '/words/chat/{id}'], function () {
    //     Route::resource('settingchats', 'SettingChatsController');
    // });
    // Route::post('/sections/future/store', 'SectionsController@future_store')->name('section.futurest');
    // Route::resource('sections', 'SectionsController',['only' => ['store']]);
    // Route::resource('chats', 'ChatsController',['only' => ['store']]);
    // Route::resource('words', 'WordsController',['only' => ['store']]);
    // Route::post('/word/destroy/{id}', 'WordsController@destroy')->name('words.destroy');
    // Route::post('/word/update/{id}', 'WordsController@update')->name('words.update');
    // Route::post('/user/blacklist/{id}', 'BlackListsController@edit')->name('user.blacklist');
    // Route::post('/user/blacklist/destroy/{id}', 'BlackListsController@destroy')->name('destroy.blacklist');    
    // Route::resource('section_trees', 'SectionTreesController',['only' =>'store']);
    // Route::resource('books', 'BooksController');
    //ユーザーページ
    
});
