<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
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
    Route::get('/index' ,"index")->middleware('permission:show Books');
    Route::post('/addBooks' ,"addBook")->middleware('permission:add book');
    Route::get('/showBook/{id}' ,"showBook")->middleware('permission:show Books');
    Route::delete('/deleteBook/{id}' ,"deleteBook")->middleware('permission:delete my book|permission:delete every book');
    Route::put('/updateBook/{id}' ,"updateBook")->middleware('permission:edit my book|permission:edit every book');
    Route::get('filter/{category}','filter');
});
Route::controller(CategoriesController::class)->group(function () {
    Route::get('/displayCategories' , 'displayCategories')->middleware('permission:show categories');
    Route::get('/showCategory/{id}' ,"showCategory")->middleware('permission:show categories');
    Route::post('/addCategory' , "addCategory")->middleware('permission:add category');
    Route::put('/updateCategory/{id}' , "updateCategory")->middleware('permission:edit category');
    Route::delete('/deleteCategory/{id}' ,  "deleteCategory")->middleware('permission:delete category');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::put('updateProfile', 'updateProfile');
    // Route::get('me', 'me');
});

 // Roles
Route::controller(RoleController::class)->group(function () {
    Route::post('assign-role/{id}', 'assignRole')->middleware('permission:assign role');
    Route::post('remove-role/{id}', 'removeRole')->middleware('permission:assign role');
});

  //Permissions
Route::group(['controller' => PermissionController::class,'middleware'=>'auth:api'], function () {
    Route::post('assign-permission/{role}','assignPermissions')->middleware('permission:assign permission');
    Route::delete('remove-permission/{role}','removePermissions')->middleware('permission:assign permission');
});
