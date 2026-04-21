<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;




Route::apiResource('posts',PostController::class);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function (Request $request) {
    return ["key1"=>"value1"];
}); 

// Route:post('/register',function (Request $request){

// });

