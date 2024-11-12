<?php

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\MyOrderPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductPage;
use App\Livewire\SuccessPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/cart', CartPage::class);
Route::get('/checkout', CheckoutPage::class);

Route::prefix('my-orders')->group(function () {
    Route::get('/', MyOrderPage::class);
    Route::get('/{order}', MyOrderDetailPage::class);
});

Route::prefix('products')->group(function () {
    Route::get('/', ProductPage::class)->name('product.index');
    Route::get('/{product}', ProductDetailPage::class)->name('product.show');
});

Route::get('/login', Login::class);
Route::get('/register', Register::class);
Route::get('/forgot', ForgotPassword::class);
Route::get('/reset', ResetPassword::class);

Route::get('/success', SuccessPage::class);
Route::get('/cancel', CancelPage::class);
