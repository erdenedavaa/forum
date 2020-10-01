<?php

    use Illuminate\Support\Facades\Route;

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

    Route::get('/', function(){
        return view('welcome');
    });


    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('threads', 'ThreadsController@index')->name('threads');
    Route::get('threads/create', 'ThreadsController@create');
    Route::post('threads', 'ThreadsController@store')->middleware('must-be-confirmed');
    Route::get('threads/{channel}', 'ThreadsController@index');
    Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
    Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');

    //Route::resource('threads', 'ThreadsController');
    Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
    Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
    Route::patch('/replies/{reply}', 'RepliesController@update');
    Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

    Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

    Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadsSubscriptionsController@store')->middleware('auth');
    Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadsSubscriptionsController@destroy')->middleware('auth');
    // Ingesneer route model binding iig ($channelId, Thread $thread) gesen mayagaar hiine gesen ug
    // middleware('auth') hiisen shaltgaan ni bid testendee auth user ogt oruulaagui

    Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
    Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');

    Route::get('/api/users', 'Api\UsersController@index');
    Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

    Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');
    Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

    Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');
