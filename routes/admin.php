<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactSubmissionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\Ecommerce\AnalyticsController as EcommerceAnalyticsController;
use App\Http\Controllers\Admin\Ecommerce\CatalogController as EcommerceCatalogController;
use App\Http\Controllers\Admin\Ecommerce\CustomersController as EcommerceCustomersController;
use App\Http\Controllers\Admin\Ecommerce\FulfillmentController as EcommerceFulfillmentController;
use App\Http\Controllers\Admin\Ecommerce\Modules\CategoryManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\CartManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\CustomerManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\DiscountManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\EcommerceSalesReportController;
use App\Http\Controllers\Admin\Ecommerce\Modules\InventorySyncController;
use App\Http\Controllers\Admin\Ecommerce\Modules\NotificationManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\OrderManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\OrderStatusTrackingController;
use App\Http\Controllers\Admin\Ecommerce\Modules\PaymentManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\ProductImageManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\ProductManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\ReturnManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\ReviewManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\ShippingManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\VideoManagementController;
use App\Http\Controllers\Admin\Ecommerce\Modules\VariantManagementController;
use App\Http\Controllers\Admin\Ecommerce\SalesController as EcommerceSalesController;
use App\Http\Controllers\Admin\InventoryRecordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin-app')
    ->name('admin.')
    ->middleware(['web', 'guest'])
    ->group(function (): void {
        Route::get('/login', [LoginController::class, 'create'])->name('login');
        Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    });

Route::prefix('admin-app')
    ->name('admin.')
    ->middleware(['web', 'admin.session'])
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

        Route::resource('users', UserController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('products', ProductController::class);
        Route::resource('inventory-records', InventoryRecordController::class);
        Route::resource('productions', ProductionController::class);
        Route::resource('sales', SaleController::class);
        Route::get('/reports', ReportController::class)->name('reports.index');
        Route::resource('contact-submissions', ContactSubmissionController::class)->only(['index', 'show', 'destroy']);

        Route::prefix('ecommerce')->name('ecommerce.')->group(function (): void {
            Route::get('/catalog', EcommerceCatalogController::class)->name('catalog');
            Route::get('/catalog/products', fn (Request $request) => redirect()->route('admin.ecommerce.catalog', array_merge($request->query(), ['module' => 'products'])))->name('catalog.products');
            Route::get('/catalog/categories', fn (Request $request) => redirect()->route('admin.ecommerce.catalog', array_merge($request->query(), ['module' => 'categories'])))->name('catalog.categories');
            Route::get('/catalog/variants', fn (Request $request) => redirect()->route('admin.ecommerce.catalog', array_merge($request->query(), ['module' => 'variants'])))->name('catalog.variants');
            Route::get('/catalog/images', fn (Request $request) => redirect()->route('admin.ecommerce.catalog', array_merge($request->query(), ['module' => 'images'])))->name('catalog.images');
            Route::get('/catalog/videos', fn (Request $request) => redirect()->route('admin.ecommerce.catalog', array_merge($request->query(), ['module' => 'videos'])))->name('catalog.videos');
            Route::post('/catalog/videos', [VideoManagementController::class, 'store'])->name('catalog.videos.store');
            Route::put('/catalog/videos/{video}', [VideoManagementController::class, 'update'])->name('catalog.videos.update');
            Route::delete('/catalog/videos/{video}', [VideoManagementController::class, 'destroy'])->name('catalog.videos.destroy');

            Route::get('/customers', EcommerceCustomersController::class)->name('customers');
            Route::get('/customers/profiles', fn (Request $request) => redirect()->route('admin.ecommerce.customers', array_merge($request->query(), ['module' => 'profiles'])))->name('customers.profiles');
            Route::get('/customers/reviews', fn (Request $request) => redirect()->route('admin.ecommerce.customers', array_merge($request->query(), ['module' => 'reviews'])))->name('customers.reviews');
            Route::get('/customers/notifications', fn (Request $request) => redirect()->route('admin.ecommerce.customers', array_merge($request->query(), ['module' => 'notifications'])))->name('customers.notifications');

            Route::get('/sales', EcommerceSalesController::class)->name('sales');
            Route::get('/sales/carts', fn (Request $request) => redirect()->route('admin.ecommerce.sales', array_merge($request->query(), ['module' => 'carts'])))->name('sales.carts');
            Route::get('/sales/orders', fn (Request $request) => redirect()->route('admin.ecommerce.sales', array_merge($request->query(), ['module' => 'orders'])))->name('sales.orders');
            Route::get('/sales/statuses', fn (Request $request) => redirect()->route('admin.ecommerce.sales', array_merge($request->query(), ['module' => 'statuses'])))->name('sales.statuses');
            Route::get('/sales/payments', fn (Request $request) => redirect()->route('admin.ecommerce.sales', array_merge($request->query(), ['module' => 'payments'])))->name('sales.payments');
            Route::get('/sales/discounts', fn (Request $request) => redirect()->route('admin.ecommerce.sales', array_merge($request->query(), ['module' => 'discounts'])))->name('sales.discounts');
            Route::get('/sales/returns', fn (Request $request) => redirect()->route('admin.ecommerce.sales', array_merge($request->query(), ['module' => 'returns'])))->name('sales.returns');

            Route::get('/fulfillment', EcommerceFulfillmentController::class)->name('fulfillment');
            Route::get('/fulfillment/inventory-sync', fn (Request $request) => redirect()->route('admin.ecommerce.fulfillment', array_merge($request->query(), ['module' => 'inventory-sync'])))->name('fulfillment.inventory-sync');
            Route::get('/fulfillment/shipping', fn (Request $request) => redirect()->route('admin.ecommerce.fulfillment', array_merge($request->query(), ['module' => 'shipping'])))->name('fulfillment.shipping');

            Route::get('/analytics', EcommerceAnalyticsController::class)->name('analytics');
            Route::get('/analytics/sales-reports', fn (Request $request) => redirect()->route('admin.ecommerce.analytics', array_merge($request->query(), ['module' => 'sales-reports'])))->name('analytics.sales-reports');
        });
    });
