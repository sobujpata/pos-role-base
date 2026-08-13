<?php

use App\Http\Controllers\BarcodeGenerateController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\PosInvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShopBannerController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\SingleBannerController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:dashboard-access');
    Route::get('/dashboard-data', [DashboardController::class, 'dashboardData'])->name('dashboard.data')->middleware('permission:dashboard-access');
    Route::get('/invoice-select-dashboard', [DashboardController::class, 'invoiceSelect'])->name('dashboard.invoice.select')->middleware('permission:dashboard-access');
    //Product Route
    Route::get('/products-list', [ProductController::class, 'index'])->name('products.index')->middleware('permission:product-menu|product-view');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('permission:product-create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store')->middleware('permission:product-create');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit')->middleware('permission:product-edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware('permission:product-edit');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:product-delete');

    //import Product Route
    Route::get("/import-product-page", [ProductController::class, 'ImportProductPage'])->name('importProductPage');
    // Import Product API
    Route::get('/import-product-all', [ProductController::class, 'ImportProductAll']);
    Route::post("/import-product", [ProductController::class, 'ImportProduct']);
    Route::get("/import-product-list/{product_id}", [ProductController::class, 'ImportProductList']);
    Route::post("/import-product-by-id", [ProductController::class, 'ImportProductsById']);
    Route::post("/import-product-update", [ProductController::class, 'ImportProductsUpdate']);
    Route::post("/import-product-delete", [ProductController::class, 'destroyImportProduct']);


    Route::get('/product-barcode-generate',
        [BarcodeGenerateController::class, 'index']
    )->name('barcode.index')->middleware('permission:product-menu|product-view');

    Route::get('/product-barcode-view/{id}',
        [BarcodeGenerateController::class, 'barcodeView']
    )->name('barcode.view')->middleware('permission:product-menu|product-view');



    //category Route
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware('permission:category-menu|category-view');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('permission:category-create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('permission:category-create');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:category-edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update')->middleware('permission:category-edit');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:category-delete');
    //brand Route
    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index')->middleware('permission:category-menu|category-view');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create')->middleware('permission:category-create');
    Route::post('/brand', [BrandController::class, 'store'])->name('brand.store')->middleware('permission:category-create');
    Route::get('/brand/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit')->middleware('permission:category-edit');
    Route::put('/brand/{id}', [BrandController::class, 'update'])->name('brand.update')->middleware('permission:category-edit');
    Route::delete('/brand/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy')->middleware('permission:category-delete');
    //Role Route
    Route::get('/roles', [RoleManagementController::class, 'index'])->name('roles.index')->middleware('permission:role-menu|role-view');
    Route::get('/roles/create', [RoleManagementController::class, 'create'])->name('role.create')->middleware('permission:role-create');
    Route::post('/roles', [RoleManagementController::class, 'store'])->name('roles.store')->middleware('permission:role-create');
    Route::get('/roles/{id}/edit', [RoleManagementController::class, 'edit'])->name('role.edit')->middleware('permission:role-edit');
    Route::put('/roles/{id}', [RoleManagementController::class, 'update'])->name('role.update')->middleware('permission:role-edit');
    Route::delete('/roles/{id}', [RoleManagementController::class, 'destroy'])->name('role.destroy')->middleware('permission:role-delete');

    //Point of sales
    Route::get('/point-of-sales', [PosInvoiceController::class, 'index'])->name('pos.index')->middleware('permission:pos-menu|pos-view');
    Route::get('/invoicePage', [PosInvoiceController::class, 'InvoicePage'])->name('invoicePage')->middleware('permission:pos-create');
    Route::get('/list-products', [PosInvoiceController::class, 'ProductList'])->middleware('permission:product-menu|product-view');
    Route::post("/pos-invoice-create", [PosInvoiceController::class, 'invoiceCreate'])->middleware('permission:pos-create');

    Route::get("/pos-invoice-select", [PosInvoiceController::class, 'invoiceSelect']);
    Route::post("/pos-invoice-details", [PosInvoiceController::class, 'InvoiceDetails']);
    Route::post("/pos-invoice-delete", [PosInvoiceController::class, 'invoiceDelete']);
    Route::post("/pos-invoice-complete", [PosInvoiceController::class, 'invoiceComplete']);
    Route::get("/pos-invoice-printed", [PosInvoiceController::class, 'invoicePrinted']);

    // POS Routes
    Route::get('/pos-by-barcode-scanner', [PosInvoiceController::class, 'posByScanner'])->name('posByBarcodeScanner');
    Route::get('/pos-products', [PosInvoiceController::class, 'posProducts'])->name('posProducts');

    Route::prefix('pos-products')->group(function () {
        Route::get('/by-barcode/{barcode}', [PosInvoiceController::class, 'getByBarcode']);
        Route::get('/search', [PosInvoiceController::class, 'search']);
        Route::get('/categories', [PosInvoiceController::class, 'getCategories']);
    });

    // Cart routes
    Route::prefix('pos-cart')->group(function () {
        Route::get('/', [PosInvoiceController::class, 'getCart']);
        Route::get('/count', [PosInvoiceController::class, 'getCartCount']);
        Route::post('/add', [PosInvoiceController::class, 'addItem']);
        Route::put('/update', [PosInvoiceController::class, 'updateItem']);
        Route::delete('/remove/{productId}', [PosInvoiceController::class, 'removeItem']);
        Route::delete('/clear', [PosInvoiceController::class, 'clearCart']);
    });

    // Checkout route (optional)
    Route::post('/pos-checkout', [PosInvoiceController::class, 'checkout'])->name('pos.checkout');

    //Report Route
    Route::get('/invoice-report', [PosInvoiceController::class, 'invoiceReport'])->name('invoiceReport')->middleware('permission:report-menu|report-view');
    Route::post('/invoice-report', [PosInvoiceController::class, 'invoiceReportGenerate'])->name('invoiceReports')->middleware('permission:report-menu|report-view');
    Route::get('/reportPage',[PosInvoiceController::class,'ReportPage'])->name('invoiceReportsPage')->middleware('permission:report-menu|report-view');
    Route::get('/list-category', [PosInvoiceController::class, 'listCategory'])->name('listCategory')->middleware('permission:report-menu|report-view');
    Route::get("/sales-report/{FormDate}/{ToDate}",[PosInvoiceController::class,'SalesReport'])->middleware('permission:report-menu|report-view');
    Route::get("/category-product/{categoryId}",[PosInvoiceController::class,'CategoryWiseProduct'])->middleware('permission:report-menu|report-view');

    //Color Route
    // Route::get('/colors', [ColorController::class, 'index'])->name('colors.index')->middleware('permission:color-menu|color-view');
    // Route::get('/colors/create', [ColorController::class, 'create'])->name('colors.create')->middleware('permission:color-create');
    // Route::post('/colors', [ColorController::class, 'store'])->name('colors.store')->middleware('permission:color-create');
    // Route::get('/colors/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit')->middleware('permission:color-update');
    // Route::put('/colors/{id}', [ColorController::class, 'update'])->name('colors.update')->middleware('permission:color-update');
    // Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy')->middleware('permission:color-delete');
    //sizes Route
    // Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index')->middleware('permission:color-menu|color-view');
    // Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create')->middleware('permission:color-create');
    // Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store')->middleware('permission:color-create');
    // Route::get('/sizes/{id}/edit', [SizeController::class, 'edit'])->name('sizes.edit')->middleware('permission:color-update');
    // Route::put('/sizes/{id}', [SizeController::class, 'update'])->name('sizes.update')->middleware('permission:color-update');
    // Route::delete('/sizes/{id}', [SizeController::class, 'destroy'])->name('sizes.destroy')->middleware('permission:color-delete');
    //tags Route
    // Route::get('/tags', [TagController::class, 'index'])->name('tags.index')->middleware('permission:color-menu|color-view');
    // Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create')->middleware('permission:color-create');
    // Route::post('/tags', [TagController::class, 'store'])->name('tags.store')->middleware('permission:color-create');
    // Route::get('/tags/{id}/edit', [TagController::class, 'edit'])->name('tags.edit')->middleware('permission:color-update');
    // Route::put('/tags/{id}', [TagController::class, 'update'])->name('tags.update')->middleware('permission:color-update');
    // Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware('permission:color-delete');
    //Subscrip route
    // Route::get('/subscribe-notice', [MenuController::class, 'subscribePage'])->name('subscribe-notice.index');
    // Route::get('/subscribe-notice/create', [MenuController::class, 'subscribePageCreate'])->name('subscribe-notice.create');
    // Route::post('/subscribe-notice', [MenuController::class, 'subscribePageStore'])->name('subscribe-notice.store');
    // Route::get('/subscribe-notice/{id}/edit', [MenuController::class, 'subscribePageEdit'])->name('subscribe-notice.edit');
    // Route::put('/subscribe-notice/{id}', [MenuController::class, 'subscribePageUpdate'])->name('subscribe-notice.update');
    // Route::delete('/subscribe-notice/{id}', [MenuController::class, 'subscribePageDestroy'])->name('subscribe-notice.destroy')->middleware('permission:color-delete');

    //permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index')->middleware('permission:permission-menu|permission-view');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('permission:permission-create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:permission-create');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:permission-edit');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:permission-edit');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('permission:permission-delete');
    //User Route
    Route::get('/users', [UsersController::class, 'index'])->name('users.index')->middleware('permission:user-menu|user-view');
    Route::get('/users/create', [UsersController::class, 'create'])->name('user.create')->middleware('permission:user-create');
    Route::post('/users', [UsersController::class, 'store'])->name('user.store')->middleware('permission:user-create');
    Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('user.edit')->middleware('permission:user-edit');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('user.update')->middleware('permission:user-edit');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('user.destroy')->middleware('permission:user-delete');
    //menu Route
    // Route::get('/menus-list', [MenuController::class, 'menuView'])->name('menus.index')->middleware('permission:menu-menu|menu-view');
    // Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create')->middleware('permission:menu-create');
    // Route::post('/menus', [MenuController::class, 'store'])->name('menus.store')->middleware('permission:menu-create');
    // Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit')->middleware('permission:menu-edit');
    // Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update')->middleware('permission:menu-edit');
    // Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy')->middleware('permission:menu-edit');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index')->middleware('permission:settings-menu');
    Route::put('/settings/popup/update', [SettingsController::class, 'updatePopUp'])->name('settings.popup-update')->middleware('permission:settings-edit');
    //shop setting route
    Route::get('shop-details', [ShopDetailController::class, 'show'])->name('shop-details.show');
    Route::get('/shop-setting', [ShopDetailController::class, 'edit'])->name('shop-details.edit')->middleware('permission:shop-menu|shop-view');
    Route::PATCH('/shop-setting/{shop}', [ShopDetailController::class, 'update'])->name('shop-details.update')->middleware('permission:shop-menu|shop-edit');
    Route::delete('/shop-setting/{shop}', [ShopDetailController::class, 'destroy'])->name('shop-details.destroy')->middleware('permission:shop-menu|shop-delete');
    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
