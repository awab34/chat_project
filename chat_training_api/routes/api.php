<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register',[AuthController::class,'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('user-data','AuthController@userData');

    Route::get('logout','AuthController@logout');

    Route::put('update-user','AuthController@update');
   
    Route::get('group-info/{id}','GroupController@showGroupInfo');

    Route::get('group-info-update/{id}','GroupController@showGroupAndFriends');

    Route::put('update-group-all-info/{id}','GroupController@updateGroupInfo');

    Route::get('send-email/', 'emailController@index');
    
    Route::post('send-email-method','emailController@sendEmail' )->name('send.email');

    Route::get('/home','GroupController@showAllChats' )->name('home');
    Route::post('group-store','GroupController@store' )->name('group.store');
    Route::get('create-group/', 'GroupController@create')->name('create.group');
    Route::get('show-group/{id}', 'GroupController@show')->name('group.show');
    Route::put('update-group/{id}', 'GroupController@update')->name('group.update');
    Route::get('delete-group/{id}', 'GroupController@destroy')->name('group.delete');
    



    Route::get('delete-message/{id}', 'MassageController@destroy')->name('message.delete');
    Route::post('message-store','MassageController@store' )->name('message.store');

    Route::get('/friends', 'FriendController@index')->name('freinds');
    Route::get('friend-info/{id}','FriendController@showFriendInfo');
    Route::get('unfriend/{id}', 'FriendController@destroy')->name('unfriend');
    Route::get('add-firend', 'FriendController@create')->name('add.firend');
    Route::post('search-friend','FriendController@search' )->name('search.friend');
    Route::post('accept-friend','FriendController@store' )->name('accept.friend');
    Route::get('message-friend/{id}','FriendController@showChatWithFreind' )->name('message.friend');
    Route::get('message-store-friend-chat','FriendController@storeFreindMessage' )->name('message.store.friend.chat');

    Route::get('request-friend/{id}','FriendRequestController@store' )->name('request.friend');
    Route::get('show-friend-requests','FriendRequestController@show_request' )->name('show.friendrequest');

    
    
});
