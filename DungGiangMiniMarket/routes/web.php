<?php


use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
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

Route::get('/shopping-cart', function () {
    return view('shopping-cart');
});



Route::get('login', [ UserController::class, 'login' ] )->name('login')->middleware('alreadyLogin');
Route::get('logout', [ UserController::class, 'logout' ] )->name('logout');
Route::post('handleLogin', [ UserController::class, 'handle_login' ] )->name('handleLogin');
Route::get('register', [ UserController::class, 'register' ] )->name('register')->middleware('alreadyLogin');


Route::middleware('loginAdmin')->group( function () {
    Route::group ([ 'prefix' => 'admin', 'as' => 'admin.' ], function () {
        Route::resource('category', CategoryController::class);
        Route::resource('cart', CartItemController::class);
        Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    } );
} );

Route::middleware('loginUser')->group( function () {
    Route::get('/', [UserController::class, 'home'])->name('/');
    Route::group ([ 'prefix' => 'user', 'as' => 'user.' ], function () {
        
    } );
} );

