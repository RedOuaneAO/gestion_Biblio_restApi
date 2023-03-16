<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
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

Route::get('/mes',function(){
    return 'hello word';
 });
 Route::controller(BooksController::class)->group(function () {
 
    Route::get('/index' , [BooksController::class , "index"]);
    Route::post('/addBooks' , [BooksController::class , "addBook"]);
});