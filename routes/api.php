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
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
});

Route::get('scholar_interests/{id}', 'Admin\ScholarController@scholar_interests');
Route::get('available_interests/{id}',  'Admin\ScholarController@available_interests');

// Funding Transactions for NewFundingTransactionComponent
Route::get('get_benefactors', 'Admin\FundingTransactionController@get_benefactors');
Route::get('get_scholars',  'Admin\FundingTransactionController@get_scholars');
Route::get('get_funding_packages',  'Admin\FundingTransactionController@get_funding_packages');
Route::get('get_scholar_funding_targets/{id}',  'Admin\FundingTransactionController@get_scholar_funding_targets');
Route::get('get_scholar_name/{id}',  'Admin\FundingTransactionController@get_scholar_name');