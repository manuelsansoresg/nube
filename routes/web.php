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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome']);

Auth::routes();


Route::get('/perfil', 'App\Http\Controllers\UserController@perfil');
Route::get('/social_user/{user_id}', 'App\Http\Controllers\UserController@social_user');
Route::resource('/usuario', 'App\Http\Controllers\UserController');

Route::get('/usuario/{user_id}/{title_id}', 'App\Http\Controllers\UserController@show');
Route::post('user/register', 'App\Http\Controllers\UserController@register')->name('usuario_register.store');

Route::post('/profiler/loadPhoto', 'App\Http\Controllers\UserController@load_photo');
Route::post('/calendar/delete', 'App\Http\Controllers\CalendarController@destroy');
Route::post('/calendar/insert', 'App\Http\Controllers\CalendarController@store');

/* api*/

Route::group(['prefix' => 'api'], function () {
    Route::get('/user/search/{search}', 'App\Http\Controllers\Api\AUserController@show');
    Route::get('/title/search/{search}', 'App\Http\Controllers\Api\ATagTitle@show');
    Route::get('/title/heart/{title_id}', 'App\Http\Controllers\Api\ATitleUserController@storeHeart');
    Route::post('/user/edit_pass', 'App\HttAUserControllerp\Controllers\Api\AUserController@update_pass')->name('edit_password.update');
    Route::get('/user/followed', 'App\Http\Controllers\Api\AUserController@followed');
    Route::get('/user/follower', 'App\Http\Controllers\Api\AUserController@follower');
    Route::get('/user/getFollowed', 'App\Http\Controllers\Api\AUserController@getFollowed');
    Route::get('/user/follow', 'App\Http\Controllers\Api\AUserController@follow');
    Route::get('/user/unfollow', 'App\Http\Controllers\Api\AUserController@unfollow');
    Route::get('/profiler/loadCalendar', 'App\Http\Controllers\Api\AUserController@userCalendar');
    /* pago */
    Route::post('/pago', 'App\Http\Controllers\Api\APaymentController@index');
});

/* Route::get('/profile/random', 'UserController@random');
Route::post('/search', 'UserController@search');
Route::post('/user/follow', 'UserController@follow');
Route::post('/user/unfollow', 'UserController@unfollow'); */