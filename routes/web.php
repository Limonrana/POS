<?php

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


Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'DashboardController@mainRoot')->name('mainRoot');
    Route::get('/dashboard', 'DashboardController@index')->name('home');

    //Customer Password Change Routes
    Route::get('/change/password', 'Auth\ConfirmPasswordController@index')->name('change.password');
    Route::post('/password/update', 'Auth\ConfirmPasswordController@Update')->name('change.password.update');

    /*======================
     * Inventory Route Start
     ======================*/
    Route::resource('/category', 'Pos\CategoryController');
    Route::post('/all-category', 'Pos\CategoryController@delete');
    Route::resource('/product', 'Pos\ProductController');
    Route::post('/products/{id}', 'Pos\ProductController@updateData')->name('product.update.data');
    Route::resource('/unit', 'Pos\UnitController');
    Route::post('/all-unit', 'Pos\UnitController@delete');
    Route::resource('/stock-management', 'Pos\StockController');
    Route::resource('/address', 'Settings\AddressController');
    //Vendor Route
    Route::resource('/vendors', 'Purchase\VendorController');
    Route::post('/vendor/{id}', 'Purchase\VendorController@updateData')->name('vendor.update');
    Route::post('/all-vendors', 'Purchase\VendorController@delete');
    Route::get('/getVendor/{id}', 'Purchase\VendorController@getVendor');
    //Purchase Route
    Route::resource('/purchase', 'Purchase\PurchaseController');
    Route::post('/purchase-update/{id}', 'Purchase\PurchaseController@updateData')->name('purchase.update.data');
    Route::get('/fulfillment/{id}', 'Purchase\PurchaseController@fulfilled')->name('purchase.fulfillment');
    Route::get('/unfulfillment/{id}', 'Purchase\PurchaseController@unfulfillment')->name('purchase.unfulfillment');
    Route::get('/pay/{id}', 'Purchase\PurchaseController@pay')->name('purchase.pay');
    Route::get('/unpay/{id}', 'Purchase\PurchaseController@unpay')->name('purchase.unpay');
    Route::get('/purchase-product/{id}', 'Purchase\PurchaseController@purchaseProduct');
    Route::post('/all-purchase', 'Purchase\PurchaseController@delete');
    Route::get('/invoice-purchase/{id}', 'Purchase\PurchaseController@generate_Invoice')->name('purchase.invoice');
    Route::get('/pdf-purchase/{id}', 'Purchase\PurchaseController@generate_pdf')->name('purchase.pdf');
    //Purchase Edit Routes Extra
    Route::post('/product-qty/{id}', 'Purchase\PurchaseController@singleQty');
    Route::post('/product-qty-update/{id}/{qty}', 'Purchase\PurchaseController@qtyUpdate');
    Route::post('/product-price/{id}', 'Purchase\PurchaseController@productPrice');

    //Cart Routes
    Route::resource('/cart', 'Pos\CartController');
    Route::get('/getCart/{id}', 'Pos\CartController@getCart');
    Route::post('/cart-update/{id}', 'Pos\CartController@cartUpdate');
    Route::post('/qty-update/{id}/{qty}', 'Pos\CartController@qtyUpdate');
    Route::post('/cartPrice/{id}', 'Pos\CartController@cartPrice');
    //Customer Route
    Route::resource('/customers', 'Sales\CustomerController');
    Route::post('/customer/{id}', 'Sales\CustomerController@updateData')->name('customer.update');
    Route::post('/all-customers', 'Sales\CustomerController@delete');
    Route::get('/getCustomer/{id}', 'Sales\CustomerController@getCustomer');
    //Sales Route
    Route::resource('/sales', 'Sales\SalesController');
    Route::post('/sales-update/{id}', 'Sales\SalesController@updateData')->name('sales.update.data');
    Route::get('/sales-fulfillment/{id}', 'Sales\SalesController@fulfilled')->name('sales.fulfillment');
    Route::get('/sales-unfulfillment/{id}', 'Sales\SalesController@unfulfillment')->name('sales.unfulfillment');
    Route::get('/sales-pay/{id}', 'Sales\SalesController@pay')->name('sales.pay');
    Route::get('/sales-unpay/{id}', 'Sales\SalesController@unpay')->name('sales.unpay');
    Route::get('/sales-product/{id}', 'Sales\SalesController@purchaseProduct');
    Route::post('/all-sales', 'Sales\SalesController@delete');
    Route::get('/invoice-sales/{id}', 'Sales\SalesController@generate_Invoice')->name('sales.invoice');
    Route::get('/pdf-sales/{id}', 'Sales\SalesController@generate_pdf')->name('sales.pdf');
    //Sales Edit Routes Extra
    Route::post('/sales-product-qty/{id}', 'Sales\SalesController@singleQty');
    Route::post('/sales-product-qty-update/{id}/{qty}', 'Sales\SalesController@qtyUpdate');
    Route::post('/sales-product-price/{id}', 'Sales\SalesController@productPrice');

    //stock management
    Route::resource('stocks', 'Pos\StockController');
    Route::get('/get-product/{id}', 'Pos\StockController@getProduct');
    //Report Route
    Route::get('/report/sales', 'Report\ReportController@sales')->name('report.sales');
    Route::get('/sales-report/{start}/{end}', 'Report\ReportController@getSales')->name('report.sales.get');
    Route::get('/report/purchase', 'Report\ReportController@purchase')->name('report.purchase');
    Route::get('/purchase-report/{start}/{end}', 'Report\ReportController@getPurchase')->name('report.purchase.get');
});
