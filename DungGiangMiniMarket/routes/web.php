<?php


use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/shop-detail', function () {
    return view('shop-detail');
});

Route::get('/shop-grid', function () {
    return view('shop-grid');
});



Route::get('login', [ UserController::class, 'login' ] )->name('login')->middleware('alreadyLogin');
Route::post('changePassword', [UserController::class, 'changePassword'])->name('changePassword');
Route::get('logout', [ UserController::class, 'logout' ] )->name('logout');
Route::post('handleLogin', [ UserController::class, 'handle_login' ] )->name('handleLogin');
Route::post('handleRegister', [ UserController::class, 'handle_register' ] )->name('handleRegister');
Route::get('register', [ UserController::class, 'register' ] )->name('register')->middleware('alreadyLogin');


Route::middleware('loginAdmin')->group( function () {
    Route::group ([ 'prefix' => 'admin', 'as' => 'admin.' ], function () {
        Route::resource('category', CategoryController::class);
        Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
        Route::resource('product', ProductController::class);
    } );
} );

Route::middleware('loginUser')->group( function () {
    Route::get('/', [UserController::class, 'home'])->name('/');
    Route::group ([ 'prefix' => 'user', 'as' => 'user.' ], function () {
        Route::resource('cart', CartItemController::class);
        Route::post('updateInfo', [UserController::class, 'updateInformation'])->name('updateInfo');
    } );
} );
