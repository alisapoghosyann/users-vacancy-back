<?php

use App\Http\Controllers\{
    UserController,
    JobVacanciesController,
    ResponsesController,
    UserLikesController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\ResponseMail;

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
//


Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(UserLikesController::class)->group(function () {
    Route::post('/likePerson', 'like');
    Route::post('/disLikePerson', 'disLikePerson');
});

Route::controller(JobVacanciesController::class)->group(function () {
    Route::get('/data' , 'index');
    Route::get('/info' , 'info');
    Route::post('/createJob', 'store');
    Route::get('/myvacancies', 'show');
    Route::post('/likeJob', 'likesJob');
    Route::post('/disLike', 'removeLike');
    Route::put('/edit', 'update');
    Route::delete('/delete', 'destroy');
});


Route::controller(ResponsesController::class)->group(function () {
    Route::post('/message', 'message');
});
Route::get('/message', function(){
    $details['email'] = 'alisapoghosyan858@gmail.com';
    dispatch(new ResponseMail($details));
    return response()->json(['message'=>'Mail Send Successfully!!']);
});
