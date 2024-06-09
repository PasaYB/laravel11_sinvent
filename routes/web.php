<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SearchController;
/*
|--------------------------------------------------------------------------
| Web Routes

|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class,'authenticate']);

Route::post('logout', [LoginController::class,'logout']);
Route::get('logout', [LoginController::class,'logout']);

Route::get('register', [RegisterController::class,'create']);
Route::post('register', [RegisterController::class,'store']);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/barang', [SearchController::class, 'searchBarang'])->name('search.barang');
Route::get('/search/kategori', [SearchController::class, 'searchKategori'])->name('search.kategori');
Route::get('/search/barang-masuk', [SearchController::class, 'searchBarangMasuk'])->name('search.barang_masuk');
Route::get('/search/barang-keluar', [SearchController::class, 'searchBarangKeluar'])->name('search.barang_keluar');





// Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
// Route::post('/add-to-cart', [KeranjangController::class, 'store'])->name('addToCart');

// Route::get('/', function(){
//     return view('dashboard');
// });

// Route::get('/hello',[DemoController::class,'hello']);

Route::get('/sija', function () {
    return"Produk Kreatif dan Kewirausahaan";
})->name('pkk');

Route::resource('barang',BarangController::class)->middleware('auth');
Route::resource('kategori',KategoriController::class)->middleware('auth');
Route::resource('barangmasuk',BarangMasukController::class)->middleware('auth');
Route::resource('barangkeluar',BarangKeluarController::class)->middleware('auth');

