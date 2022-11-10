<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//GET
Route::get('prouduct/list',[RouteController::class,'productapi']);
Route::get('category/list',[RouteController::class,'categoryapi']);


//POST
Route::post('create/category',[RouteController::class,'createCategory']);
Route::post('create/contact',[RouteController::class,'createContact']);

//delete
Route::post('delete/category',[RouteController::class,'deleteCategory']);
// Route::get('delete/category/{id}',[RouteController::class,'deleteCategory']);

//edit & update
Route::get('deatils/category/{id}',[RouteController::class,'deatilsCategory']);
Route::post('update/category',[RouteController::class,'updateCategory']);


// http://localhost:8000/api/prouduct/list (GET)
// http://localhost:8000/api/category/list  (GET)

// http://localhost:8000/api/create/category (POST)
// http://localhost:8000/api/create/contact (POST)

// http://localhost:8000/api/delete/category (POST)

//  http://localhost:8000/api/deatils/category/{id} (Get)
//  http://localhost:8000/api/update/category  (POST)

