<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Vendor\Dashboard as VendorDashboard;
use App\Livewire\Vendor\Products\Index as ProductIndex;
use App\Livewire\Vendor\Products\Create as ProductCreate;
use App\Livewire\Vendor\Products\Edit as ProductEdit;
use App\Livewire\Vendor\OrdersIndex;
use App\Livewire\Vendor\ShopSettings;
use App\Livewire\Vendor\SalesReports;
use App\Livewire\Vendor\Support;
use App\Livewire\Vendor\Profile;

use App\Livewire\Buyer\Dashboard as BuyerDashboard;
use App\Livewire\Buyer\SubscribeProduct;
use App\Livewire\Buyer\BuyerProductList;
use App\Livewire\Buyer\AddToCart;
use App\Livewire\Buyer\Checkout;
use App\Livewire\Buyer\Cart;
use App\Http\Controllers\WebhookController;
use App\Livewire\Buyer\CheckoutSuccess;
use App\Livewire\Buyer\OrdersList;
use App\Http\Controllers\InvoiceController;
use App\Livewire\Buyer\NotificationsDropdown;
use App\Livewire\Buyer\SubscriptionsList;
use App\Livewire\Buyer\InvoicesList;
use App\Livewire\Buyer\Avater;


use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\UsersIndex;
use App\Livewire\Admin\ShopsIndex; 
use App\Livewire\Admin\ProductShow;
use App\Livewire\Admin\OrdersInvoices;
use App\Livewire\Admin\Subscriptions;
 use App\Livewire\Admin\ReportsIndex;
use App\Livewire\Admin\Settings;



// use App\Livewire\Vendor\ProductForm;
// use App\Livewire\Vendor\ProductList;
// use App\Livewire\Vendor\ProductGallery;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    

require __DIR__.'/auth.php';


Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);

 
 
Route::get('/notifications', function () {
    return view('notifications.index');
})->name('notifications.index');

 
Route::get('/notifications/read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->route('notifications.index');
})->name('notifications.read.get');

 
Route::post('/notifications/read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->route('notifications.index');
})->name('notifications.read');


// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
         Route::get('/users', UsersIndex::class)->name('users.index');
            Route::get('/shops', ShopsIndex::class)->name('shops.index');
            Route::get('/products',ProductShow::class)->name('products.index');
             Route::get('/orders-invoices', OrdersInvoices::class)->name('orders.invoices');
             Route::get('/subscriptions', Subscriptions::class)->name('subscriptions');
            Route::get('/reports', ReportsIndex::class)->name('reports');
    Route::get('/settings', Settings::class)->name('settings');




    });


// Vendor (Seller) Routes
Route::middleware(['auth', 'role:seller'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', VendorDashboard::class)->name('dashboard');
    Route::get('/products', ProductIndex::class)->name('products.index');
    Route::get('/products/create', ProductCreate::class)->name('products.create');
    Route::get('/products/{product}/edit', ProductEdit::class)->name('products.edit');
    Route::delete('/products/{product}', ProductIndex::class)->name('products.delete');
    Route::get('/orders', OrdersIndex::class)->name('orders.index');
    Route::get('/shop-settings', ShopSettings::class)->name('shop.settings');
      Route::get('/sales-reports', SalesReports::class)->name('sales.reports');
      Route::get('/support', Support::class)->name('support');
    // Route::get('/orders',  SellerOrders::class)->name('orders.index');
    Route::get('/profile',  Profile::class)->name('profile');
});


// Buyer Routes
// Buyer Routes
Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', BuyerDashboard::class)->name('dashboard');
    Route::get('/subscribe/{productId}', SubscribeProduct::class)->name('subscribe');
    Route::get('/productlist', BuyerProductList::class)->name('product.list');
    Route::get('/notifications', NotificationsDropdown::class)->name('notifications');
    Route::get('/subscriptions', SubscriptionsList::class)->name('subscriptions');
    Route::get('/invoices', InvoicesList::class)->name('invoices');
     Route::get('/avater', Avater::class)->name('avater');
    // Change POST to GET for Livewire AddToCart component route
    Route::get('/add-to-cart/{productId}', AddToCart::class)->name('add-to-cart');
     Route::get('/orders', OrdersList::class)
        ->name('orders.index');
 Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/cart', Cart::class)->name('cart');
   Route::get('/checkout/success', CheckoutSuccess::class)->name('checkout.success');
    Route::get('/checkout/cancel', function () {
        return view('checkout-cancel');
    })->name('checkout.cancel');
});
    Route::get('/invoice/download/{invoice}', [InvoiceController::class, 'download'])->name('invoice.download');
 
