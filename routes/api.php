<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Notifications\Notifiable;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('questions','QuestionController');
Route::apiResource('categories','CategoryController');
Route::apiResource('questions/{question}/replies','ReplyController');


Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
Route::get('notifications','NotificationController@notification');
Route::post('notifications','NotificationController@readNotifications');



Route::group(['middleware' => 'auth.jwt'], function () {

    Route::get('logout', 'ApiController@logout');
    Route::post('/{reply}/like','LikeController@like');
    Route::delete('/{reply}/like','LikeController@unlike');




});
