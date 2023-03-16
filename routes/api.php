<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
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

    Route::get('/index' , [BooksController::class , "index"]);
    Route::post('/addBooks' , [BooksController::class , "addBook"]);
    Route::get('/showBook/{id}' , [BooksController::class , "showBook"]);
    Route::delete('/deleteBook/{id}' , [BooksController::class , "deleteBook"]);
    Route::put('/updateBook/{id}' , [BooksController::class , "updateBook"]);
});
Route::controller(CategoriesController::class)->group(function () {

    Route::get('/displayCategories' , [CategoriesController::class , "displayCategories"]);
    Route::post('/addCategory' , [CategoriesController::class , "addCategory"]);
    Route::get('/showCategory/{id}' , [CategoriesController::class , "showCategory"]);
    Route::delete('/deleteCategory/{id}' , [CategoriesController::class , "deleteCategory"]);
    Route::put('/updateCategory/{id}' , [CategoriesController::class , "updateCategory"]);
});