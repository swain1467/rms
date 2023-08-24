<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('Register', 'App\Http\Controllers\user\SignUpController@Register')->middleware('cors');
Route::post('LogIn', 'App\Http\Controllers\user\SignInController@LogIn')->middleware('cors');

Route::post('SendOTP', 'App\Http\Controllers\user\RetrievePasswordController@SendOTP')->middleware('cors');
Route::post('Verify', 'App\Http\Controllers\user\RetrievePasswordController@Verify')->middleware('cors');


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::get('GetHouseTypeList', 'App\Http\Controllers\admin\SetupController@GetHouseTypeList')->middleware('cors');
    Route::post('Refresh', 'App\Http\Controllers\user\SignInController@refresh')->middleware('cors');
    Route::get('Me', 'App\Http\Controllers\user\SignInController@me');

    Route::get('GetCity', 'App\Http\Controllers\user\PostController@GetAPICity');
    Route::post('GetArea', 'App\Http\Controllers\user\PostController@GetAPIArea');
    Route::get('GetType', 'App\Http\Controllers\user\PostController@GetAPIType');
    Route::post('SavePostProperty', 'App\Http\Controllers\user\PostController@SavePostProperty');

    Route::post('GetAvailableHouseList', 'App\Http\Controllers\user\FindController@GetAPIAvailableHouseList');

    Route::post('GetHouseList', 'App\Http\Controllers\user\PostHistoryController@GetAPIHouseList');
    Route::post('GetHouseData', 'App\Http\Controllers\user\PostHistoryController@GetAPIHouseData');
    Route::post('UpdateHouse', 'App\Http\Controllers\user\PostHistoryController@UpdateAPIHouse');
    Route::post('DeleteHouse', 'App\Http\Controllers\user\PostHistoryController@DeleteAPIHouse');
});