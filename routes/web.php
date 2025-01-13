<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;

Route::get('/', [HomeController::class, 'getHomePage'])->name('home');

Route::middleware('check.logout')->group(function () {
	Route::get('/login', [AuthController::class, 'getLoginPage'])->name('login_page');
	Route::post('/login', [AuthController::class, 'login'])->name('login');

	Route::get('/register', [AuthController::class, 'getRegisterPage'])->name('register_page');
	Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::prefix('product')->name('product.')->group(function () {
	Route::get('/{id}', [ProductController::class, 'getProductDetail'])->name('detail');
});

Route::prefix('search')->name('search.')->group(function () {
	Route::get('/', [HomeController::class, 'searchKey'])->name('search');
	Route::get('/suggestions', [HomeController::class, 'searchSuggestions'])->name('suggestions');
	Route::get('/brand/{id}', [HomeController::class, 'searchBrand'])->name('brand');
	Route::get('/category/{id}', [HomeController::class, 'searchCategory'])->name('category');
	Route::get('/shop/{id}', [HomeController::class, 'searchShop'])->name('shop');
});

Route::middleware('check.login')->group(function () {
	Route::prefix('cart')->name('cart.')->group(function () {
		Route::get('/', [CartController::class, 'getCartDetail'])->name('detail');
		Route::post('/add', [CartController::class, 'addToCart'])->name('add');
		Route::post('/update', [CartController::class, 'updateProductCart'])->name('update');
		Route::delete('/delete/{id}', [CartController::class, 'deleteProductCart'])->name('delete');
		Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
	});

	Route::prefix('user')->name('user.')->group(function () {
		Route::get('/info', [UserController::class, 'getProfileInfoPage'])->name('info');
		Route::get('/change_password', [UserController::class, 'getChangePasswordPage'])->name('change_password');
		Route::get('/purchase', [PurchaseController::class, 'getPurchasePage'])->name('purchase');

		Route::prefix('address')->name('address.')->group(function () {
			Route::get('/', [AddressController::class, 'getAddressPage'])->name('page');
			Route::get('/district', [AddressController::class, 'getDistrictList'])->name('district');
			Route::get('/commune', [AddressController::class, 'getCommuneList'])->name('commune');
			Route::post('/add', [AddressController::class, 'addAddress'])->name('add');
			Route::delete('/delete/{id}', [AddressController::class, 'deleteAddress'])->name('delete');
			Route::get('/get/{id}', [AddressController::class, 'getAddress'])->name('get');
			Route::put('/update/{id}', [AddressController::class, 'updateAddress'])->name('update');
		});

		Route::prefix('voucher')->name('voucher.')->group(function () {
			Route::get('/', [VoucherController::class, 'getVoucherPage'])->name('page');
		});
	});

	Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

	Route::prefix('payment')->name('payment.')->group(function () {
		Route::get('/', [PaymentController::class, 'getPaymentDetail'])->name('detail');
		Route::post('/submit', [PaymentController::class, 'submitPayment'])->name('submit');
		Route::post('/apply_voucher', [VoucherController::class, 'applyVoucher'])->name('apply_voucher');
	});
});

Route::middleware('check.login')->prefix('admin')->name('admin.')->group(function () {
	Route::prefix('product')->name('product.')->group(function () {
		Route::get('/', [AdminProductController::class, 'getProductPage'])->name('page');
		Route::get('/get_list', [AdminProductController::class, 'getProductSelly'])->name('get_product_selly');
		Route::post('/get_list_ajax', [AdminProductController::class, 'getProductSellyAjax'])->name('ajax');
		Route::get('/get_product_info_ajax', [AdminProductController::class, 'getProductInfoSellyAjax'])->name('get_product_info_ajax');
	});
	Route::prefix('voucher')->name('voucher.')->group(function () {
		Route::get('/', [AdminVoucherController::class, 'list'])->name('list');
		Route::match(['get', 'post'], '/create', [AdminVoucherController::class, 'create'])->name('create');
		Route::match(['get', 'put'], '/update/{voucher}', [AdminVoucherController::class, 'update'])->name('update');
	});
});
