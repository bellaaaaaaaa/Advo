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


// Routes for admin web ReportCardComponent
Route::prefix('admin')->group(function(){
    Route::get('users_report_cards/{id}', 'Admin\ReportCardsController@usersreportcards');
    Route::get('report_cards/{id}', 'Admin\ReportCardsController@show');
    Route::post('report_cards', 'Admin\ReportCardsController@store');
    Route::post('report_cards/{id}', 'Admin\ReportCardsController@update');
    Route::delete('report_cards/{id}', 'Admin\ReportCardsController@destroy');
});
Route::get('user_interests/{id}', 'Admin\UsersController@interests');
Route::get('user_interests_options/{id}',  'Admin\UsersController@allinterests');

// Routes for admin web  UserInterestsComponent
Route::get('user_interests/{id}', 'Admin\UsersController@interests');
Route::get('user_interests_options/{id}',  'Admin\UsersController@allinterests');
Route::post('user_interest/{id}',  'Admin\UsersController@adduserinterest');
Route::delete('user_interest/{id}',  'Admin\UsersController@deleteuserinterest');

// Routes for admin web  UserBadgesComponent
Route::get('user_badges/{id}', 'Admin\UsersController@badges');
Route::get('user_badges_options/{id}',  'Admin\UsersController@allbadges');
Route::get('get_selected_badge/{id}',  'Admin\UsersController@getselectedbadge');
Route::post('user_badge/{id}',  'Admin\UsersController@adduserbadge');
Route::delete('user_badge/{id}',  'Admin\UsersController@deleteuserbadge');

// Funding Transactions for NewFundingTransactionComponent
Route::get('get_benefactors', 'Admin\FundingTransactionController@get_benefactors');
Route::get('get_scholars',  'Admin\FundingTransactionController@get_scholars');
Route::get('get_funding_packages',  'Admin\FundingTransactionController@get_funding_packages');
Route::get('get_scholar_funding_targets/{id}',  'Admin\FundingTransactionController@get_scholar_funding_targets');
Route::get('get_scholar_name/{id}',  'Admin\FundingTransactionController@get_scholar_name');

// Vue Update User
Route::get('get_user/{id}', 'Admin\UsersController@get_user');