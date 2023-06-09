<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;
use Nafezly\Payments\Classes\PayPalPayment;
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
Route::fallback(function () {
    return redirect('/');
});
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [
            'localeSessionRedirect',
            'localizationRedirect',
            'localeViewPath',
        ],
    ],
    function () {
        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::get('/profile', [ProfileController::class, 'index'])->name(
            'profile'
        );
        Route::put('/profile', [ProfileController::class, 'update'])->name(
            'profile.update'
        );
        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
        // Route::get('login', function () {
        //     return view('frontend.auth.login');
        // })->name('login');

        Route::get('/about', [AboutController::class, 'index'])->name('about');

        Route::get('/contact', function () {
            return view('frontend.contact');
        })->name('contact');

        Route::get('/product', [ProductController::class, 'index'])->name(
            'product'
        );
        Route::get('/product/show/{id}', [
            ProductController::class,
            'show',
        ])->name('product.show');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name(
            'checkout'
        );
        Route::post('/checkout', [CheckoutController::class, 'store'])->name(
            'checkout.payment'
        );

        ////////////////////////////////////////paymentt

        Route::post('checkout/credit-card', [
            CheckoutController::class,
            'afterPayment',
        ])->name('checkout.credit-card');

        Route::get('/state', [CheckoutController::class, 'state'])->name(
            'state'
        );
        Route::get('/cansel', [CheckoutController::class, 'cansel'])->name(
            'cansel'
        );

        Route::get('/payments/verify/{payment?}', [
            PayPalPayment::class,
            'verify',
        ])->name('payment-verify');

        /////////////////////////
        Route::get('/dashboard', function () {
            return view('dashboard');
        })
            ->middleware(['auth'])
            ->name('dashboard');

        require __DIR__ . '/auth.php';

        // Auth::routes();

        // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Auth::routes();

        Route::get('/home', [
            App\Http\Controllers\HomeController::class,
            'index',
        ])->name('home');

        //////////////////test
        Route::put('test', function () {
            return response()->json(['message' => 'delete']);
        });
    }
);
