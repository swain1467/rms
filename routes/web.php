<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Artisan::call('cache:clear');
Artisan::call('route:clear');

// Route::get('/', function () {
//     return view('user.signup');
// });

Route::get('/', 'App\Http\Controllers\user\SignUpController@SignUpView')->name('user_sign_up');
Route::post('SaveUser', 'App\Http\Controllers\user\SignUpController@Save');

Route::get('SignIn', 'App\Http\Controllers\user\SignInController@SignInView')->name('user_sign_in');
Route::post('CheckLogIn', 'App\Http\Controllers\user\SignInController@CheckSignIn');

Route::get('RetrievePassword', 'App\Http\Controllers\user\RetrievePasswordController@RetrievePasswordView')->name('user_retrieve_password');
Route::post('SendOTP', 'App\Http\Controllers\user\RetrievePasswordController@SendOTP');
Route::post('Verify', 'App\Http\Controllers\user\RetrievePasswordController@Verify');
Route::post('Verify', 'App\Http\Controllers\user\RetrievePasswordController@Verify');

//Protected
Route::get('UserDashboard', 'App\Http\Controllers\user\UserDashboardController@View')
->name('user_dashboard')->middleware('web_guard');

Route::get('SignOut', 'App\Http\Controllers\user\UserDashboardController@SignOut')
->name('sign_out')->middleware('web_guard');

// Find House
Route::get('Find', 'App\Http\Controllers\user\FindController@FindView')
->name('find_hc')->middleware('web_guard');
Route::get('GetAvailableHouseList', 'App\Http\Controllers\user\FindController@GetAvailableHouseList')->middleware('web_guard');


// Post Controller Starts From Here
Route::get('Post', 'App\Http\Controllers\user\PostController@PostView')
->name('post_hc')->middleware('web_guard');

Route::get('GetCity', 'App\Http\Controllers\user\PostController@GetCity')->middleware('web_guard');
Route::get('GetArea', 'App\Http\Controllers\user\PostController@GetArea')->middleware('web_guard');
Route::get('GetType', 'App\Http\Controllers\user\PostController@GetType')->middleware('web_guard');
Route::post('SavePost', 'App\Http\Controllers\user\PostController@SavePost')->middleware('web_guard');

Route::get('PostHistory', 'App\Http\Controllers\user\PostHistoryController@PostHistoryView')
->name('post_history')->middleware('web_guard');
Route::get('GetHouseList', 'App\Http\Controllers\user\PostHistoryController@GetHouseList')->middleware('web_guard');
Route::get('MoveToTrash', 'App\Http\Controllers\user\PostHistoryController@MoveToTrash')->middleware('web_guard');
Route::post('UpdateHouse', 'App\Http\Controllers\user\PostHistoryController@UpdateHouse')->middleware('web_guard');

Route::get('MyTrash', 'App\Http\Controllers\user\PostHistoryController@MyTrashView')
->name('my_trash')->middleware('web_guard');
Route::get('GetTrashHouseList', 'App\Http\Controllers\user\PostHistoryController@GetTrashHouseList')->middleware('web_guard');
Route::get('RestoreHouse', 'App\Http\Controllers\user\PostHistoryController@RestoreHouse')->middleware('web_guard');
Route::get('DeleteHouse', 'App\Http\Controllers\user\PostHistoryController@DeleteHouse')->middleware('web_guard');

// Admin Pages Starts from Here
Route::get('AdminDashboard', 'App\Http\Controllers\admin\AdminDashboardController@AdminDashboardView')
->name('admin_dashboard')->middleware('admin_guard');

Route::get('ActiveUsers', 'App\Http\Controllers\admin\UserController@ActiveUsersView')
->name('active_users')->middleware('admin_guard');

Route::get('BlackListedUsers', 'App\Http\Controllers\admin\UserController@BlackListedUsersView')
->name('black_listed_users')->middleware('admin_guard');

Route::get('Setup', 'App\Http\Controllers\admin\SetupController@SetupView')
->name('setup')->middleware('admin_guard');

Route::get('Transition', 'App\Http\Controllers\admin\TransitionController@TransitionView')
->name('transition')->middleware('admin_guard');