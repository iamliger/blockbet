<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
$maintenance = false;
if($maintenance){

}else{
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>['auth:api']],function(){
    Route::post('/betting','GameController@bet')->name("bet.create");
    Route::post('/user/transfer','GameController@transfer')->name('transfer');
    Route::get('/oddeven/myresult','GameController@oddEven_myresult')->name('api.myresult.oddeven');
    Route::get('/underover/myresult','GameController@underOver_myresult')->name('api.myresult.underOver');
    Route::get('/under/myresult','GameController@under_myresult')->name('api.myresult.under');   

    Route::get('/oddeven40/myresult','GameController@oddEven40_myresult')->name('api.myresult.oddeven40');
    Route::get('/underover40/myresult','GameController@underOver40_myresult')->name('api.myresult.underOver40');
    Route::get('/under40/myresult','GameController@under40_myresult')->name('api.myresult.under40');   
 });
 Route::get('/oddeven/result','GameController@oddEven_result')->name('api.result.oddeven');
 Route::get('/underover/result','GameController@underOver_result')->name('api.result.underOver');
 Route::get('/under/result','GameController@under_result')->name('api.result.under');

 Route::get('/oddeven40/result','GameController@oddEven40_result')->name('api.result.oddeven40');
 Route::get('/underover40/result','GameController@underOver40_result')->name('api.result.underOver40');
 Route::get('/under40/result','GameController@under40_result')->name('api.result.under40');

}