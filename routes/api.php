<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AuthController;
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


Route::controller(BooksController::class)->group(function () {
    Route::get('/index' ,"index");
    Route::post('/addBooks' ,"addBook");
    Route::get('/showBook/{id}' ,"showBook");
    Route::delete('/deleteBook/{id}' ,"deleteBook");
    Route::put('/updateBook/{id}' ,"updateBook");
});
Route::controller(CategoriesController::class)->group(function () {
    Route::get('/displayCategories' , 'displayCategories');
    Route::post('/addCategory' , "addCategory");
    Route::get('/showCategory/{id}' ,"showCategory");
    Route::delete('/deleteCategory/{id}' ,  "deleteCategory");
    Route::put('/updateCategory/{id}' , "updateCategory");
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    // Route::get('me', 'me');
});