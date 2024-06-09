<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));

//posts
Route::apiResource('/barang', App\Http\Controllers\Api\BarangController::class);
Route::apiResource('/kategori', App\Http\Controllers\Api\KategoriController::class);