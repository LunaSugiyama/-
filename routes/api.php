<?php

use App\Models\user;
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
//use APP\HTTP\Controller\API\FileController;
Route::post('/register_email','App\Http\Controllers\EmailVerificationController@build');
//Route::post('/email_register','App\Http\Controllers\RegisterController@create');
//use App\Http\Controllers\RegisterController;
//Route::post('/email_register','RegisterController@create');
Route::post('/index','App\Http\Controllers\HomeController@index');
Route::post('/send_email','App\Http\Controllers\EmailController@index');
Route::post('/email_pre_check','App\Http\Controllers\Auth\RegisterController@create');

Route::get('/mail','App\Http\Controllers\EmailController@index');
Route::get('/login','App\Http\Controllers\Auth\LoginController@login')

;//use App\Http\Controllers\RegisterController;
//Route::post('/email_register',[RegisterController::class,'create']);
//Route::post('/email/register',['App\Http\Controllers\RegisterController'::class ,'create']);
Route::post('/code','App\Http\Controllers\TwoFactorAuthController@code_auth');
Route::get('/enter_code','App\Http\Controllers\TwoFactorAuthController@enter_code');
Route::get('/change_pass','App\Http\Controllers\Auth\ChangePasswordController@update');

Route::post('/reset_pass','App\Http\Controllers\Auth\ForgotPasswordController@make_token');
Route::get('/reset_comp','App\Http\Controllers\Auth\ForgotPasswordController@enter_code');


Route::post('/changepass','App\Http\Controllers\NodoubleController@update');
Route::post('/pass_hist','App\Http\Controllers\NodoubleController@samepass');
Route::post('/logout','App\Http\Controllers\Auth\LogoutController@logout');
Route::post('/getinfo','App\Http\Controllers\GetinfoController@getinfo');
