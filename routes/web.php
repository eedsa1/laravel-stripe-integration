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

Route::get('/', function () {
    return view('welcome');
});

###############################################
#### Payments
###############################################

Route::get('/index1', 'StripeController@index1');

Route::get('/index2', 'StripeController@index2');

Route::post('/pagamentoStripe', 'StripeController@pagamentoStripe');

Route::post('/pagamentoStripeElements', 'StripeController@pagamentoStripeElements');

Route::get('/refund', 'StripeController@refund');

Route::post('/saveCard', 'StripeController@saveCard');

##############################################
#### Users
##############################################

Route::get('/createUser', 'StripeController@createUser');

Route::get('/searchUser', 'StripeController@searchUser');

##############################################
#### Subscriptions
##############################################

Route::get('/createProduct', 'StripeController@createProduct');

Route::get('/createPlan', 'StripeController@createPlan');

Route::get('/createSubscription', 'StripeController@createSubscription');

################################################
#### Webhooks
################################################

Route::post('/eventListener', 'StripeController@eventListener');