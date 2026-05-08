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
            Route::get('/catalog/products', ProductManagementController::class)->name('catalog.products');
            Route::get('/catalog/categories', CategoryManagementController::class)->name('catalog.categories');
            Route::get('/catalog/variants', VariantManagementController::class)->name('catalog.variants');
            Route::get('/catalog/images', ProductImageManagementController::class)->name('catalog.images');
            Route::get('/catalog/videos', [VideoManagementController::class, 'index'])->name('catalog.videos');
            Route::post('/catalog/videos', [VideoManagementController::class, 'store'])->name('catalog.videos.store');
            Route::delete('/catalog/videos/{video}', [VideoManagementController::class, 'destroy'])->name('catalog.videos.destroy');

            Route::get('/customers', EcommerceCustomersController::class)->name('customers');
            Route::get('/customers/profiles', CustomerManagementController::class)->name('customers.profiles');
            Route::get('/customers/reviews', ReviewManagementController::class)->name('customers.reviews');
            Route::get('/customers/notifications', NotificationManagementController::class)->name('customers.notifications');

            Route::get('/sales', EcommerceSalesController::class)->name('sales');
            Route::get('/sales/carts', CartManagementController::class)->name('sales.carts');
            Route::get('/sales/orders', OrderManagementController::class)->name('sales.orders');
            Route::get('/sales/statuses', OrderStatusTrackingController::class)->name('sales.statuses');
            Route::get('/sales/payments', PaymentManagementController::class)->name('sales.payments');
            Route::get('/sales/discounts', DiscountManagementController::class)->name('sales.discounts');
            Route::get('/sales/returns', ReturnManagementController::class)->name('sales.returns');

            Route::get('/fulfillment', EcommerceFulfillmentController::class)->name('fulfillment');
            Route::get('/fulfillment/inventory-sync', InventorySyncController::class)->name('fulfillment.inventory-sync');
            Route::get('/fulfillment/shipping', ShippingManagementController::class)->name('fulfillment.shipping');

            Route::get('/analytics', EcommerceAnalyticsController::class)->name('analytics');
            Route::get('/analytics/sales-reports', EcommerceSalesReportController::class)->name('analytics.sales-reports');
        });
    });
