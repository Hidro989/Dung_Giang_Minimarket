<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/storage/{filename}', function ($filename) {
//     $path = storage_path('app/public/' . $filename);
//     if (!Storage::exists($path)) {
//         abort(404);
//     }
//     return response()->file($path);
// })->where('filename', '.*');

Route::get('/contact', function () {
    return view('contact');
});


Route::get('/shop-grid/{category_id}',[ProductController::class,'shop_grid'])->name('product.shop_grid');
Route::get('/product/search',[ProductController::class,'search'])->name('product.search');

Route::get('product/find',[ProductController::class,'find']);
Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');


Route::get('login', [ UserController::class, 'login' ] )->name('login')->middleware('alreadyLogin');
Route::post('changePassword', [UserController::class, 'changePassword'])->name('changePassword');
Route::get('logout', [ UserController::class, 'logout' ] )->name('logout');
Route::post('handleLogin', [ UserController::class, 'handle_login' ] )->name('handleLogin');
Route::post('handleRegister', [ UserController::class, 'handle_register' ] )->name('handleRegister');
Route::get('register', [ UserController::class, 'register' ] )->name('register')->middleware('alreadyLogin');
Route::resource('review',ReviewController::class);


Route::middleware('loginAdmin')->group( function () {
    Route::group ([ 'prefix' => 'admin', 'as' => 'admin.' ], function () {
        Route::resource('category', CategoryController::class);
        Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::resource('product', ProductController::class);
        Route::get('order/index', [OrderController::class, 'index'])->name('order.index');
        Route::get('order/update_status', [OrderController::class, 'update_status'])->name('order.update_status');
    } );
} );

Route::middleware('loginUser')->group( function () {
    Route::get('/', [UserController::class, 'home'])->name('/');
    Route::group ([ 'prefix' => 'user', 'as' => 'user.' ], function () {
        Route::get('cart/index/{user_id}', [CartController::class, 'index'])->name('cart.index');
        Route::get('cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::get('cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('order/checkout/{user_id}', [OrderController::class, 'checkout'])->name('order.checkout');
        Route::post('order/stored', [OrderController::class, 'stored'])->name('order.stored');
        Route::post('updateInfo', [UserController::class, 'updateInformation'])->name('updateInfo');
    } );
} );
