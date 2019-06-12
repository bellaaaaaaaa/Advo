<?php

use Illuminate\Http\Request;

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
Route::middleware('passport.client.auth')->group(function () {
    Route::post('login', 'API\UserController@login');
    Route::post('register', 'API\UserController@register');
    // Route::get('report_cards', 'Admin\ReportCardsController@index');
    // Route::get('report_cards/{id}', 'Admin\ReportCardsController@show');
    // Route::post('report_cards', 'Admin\ReportCardsController@store');
    // Route::post('report_cards/{id}', 'Admin\ReportCardsController@update');
    // Route::delete('report_cards/{id}', 'Admin\ReportCardsController@destroy');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
});

// Routes for admin web
Route::prefix('admin')->group(function(){
    Route::get('report_cards', 'Admin\ReportCardsController@index');
    Route::get('report_cards/{id}', 'Admin\ReportCardsController@show');
    Route::post('report_cards', 'Admin\ReportCardsController@store');
    Route::post('report_cards/{id}', 'Admin\ReportCardsController@update');
    Route::delete('report_cards/{id}', 'Admin\ReportCardsController@destroy');
});
Route::get('user_interests/{id}', 'Admin\UsersController@interests');
Route::get('user_interests_options/{id}',  'Admin\UsersController@allinterests');
