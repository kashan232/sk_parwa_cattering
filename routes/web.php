<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Sub_cat_Cotnroller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemProductController;
use App\Http\Controllers\KitchenInventoryController;
use App\Http\Controllers\MenuEstimateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffSalaryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\warehouseStockController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// code deploy 
// pos start
// Old Pos setup
// Software deployed
// Checking

Route::get('/', [HomeController::class, 'welcome']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', [HomeController::class, 'home'])->middleware(['auth'])->name('home');
Route::get('/admin-page', [HomeController::class, 'adminpage'])->name('admin-page');
Route::get('/Admin-Change-Password', [HomeController::class, 'Admin_Change_Password'])->name('Admin-Change-Password');
Route::post('/updte-change-Password', [HomeController::class, 'updte_change_Password'])->name('updte-change-Password');

// staff dashboard work 
Route::get('/get-products-by-category', [HomeController::class, 'getProductsByCategory'])->name('get.products.by.category');
Route::get('/get-product-by-barcode', [HomeController::class, 'getProductByBarcode'])->name('get.product.by.barcode');


//category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/store-category', [CategoryController::class, 'store_category'])->name('store-category');
Route::post('/update-category', [CategoryController::class, 'update_category'])->name('update-category');

//Sub category 
Route::get('/sub-category', [Sub_cat_Cotnroller::class, 'sub_category'])->name('subcategory');
Route::post('/sub-store-category', [Sub_cat_Cotnroller::class, 'store_sub_category'])->name('store-subcategory');
Route::post('/sub-update-category', [Sub_cat_Cotnroller::class, 'update_sub_category'])->name('update-subcategory');


//brand
Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/store-brand', [BrandController::class, 'store_brand'])->name('store-brand');
Route::post('/update-brand', [BrandController::class, 'update_brand'])->name('update-brand');

//unit
Route::get('/unit', [UnitController::class, 'unit'])->name('unit');
Route::post('/store-unit', [UnitController::class, 'store_unit'])->name('store-unit');
Route::post('/update-unit', [UnitController::class, 'update_unit'])->name('update-unit');

//product
Route::get('/all-product', [ProductController::class, 'all_product'])->name('all-product');
Route::get('/add-product', [ProductController::class, 'add_product'])->name('add-product');
Route::post('/store-product', [ProductController::class, 'store_product'])->name('store-product');
Route::get('/edit-product/{id}', [ProductController::class, 'edit_product'])->name('edit-product');
Route::post('/update-product/{id}', [ProductController::class, 'update_product'])->name('update-product');
Route::get('/product-alerts', [ProductController::class, 'product_alerts'])->name('product-alerts');
Route::get('/get-subcategories/{category}', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
Route::get('/get-items/{category}/{subcategory}', [ProductController::class, 'getItems'])->name('get.items');
Route::post('/delete-product', [ProductController::class, 'delete_product'])->name('delete.product');


//Order
Route::get('/all-order', [OrderController::class, 'all_order'])->name('all-order');
Route::get('/add-order', [OrderController::class, 'add_order'])->name('add-order');
Route::post('/store-order', [OrderController::class, 'store_order'])->name('store-order');
Route::get('/invoice/{id}', [OrderController::class, 'show'])->name('invoice.show');
Route::post('/order/payment', [OrderController::class, 'paymentUpdate'])->name('order.payment');
Route::get('/Voucher/{id}', [OrderController::class, 'show_voucher'])->name('Voucher.show');
Route::post('/order/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
// web.php
Route::post('/fetch-vendor-assignments', [OrderController::class, 'fetchVendorAssignments'])->name('fetch-vendor-assignments');
Route::post('/save-order', [OrderController::class, 'save_order'])->name('save.order');

Route::get('/online-order', [OrderController::class, 'online_order'])->name('online-order');
Route::post('/gatepass/store', [OrderController::class, 'store'])->name('gatepass.store');
Route::get('/get-order-inventory/{order}', [OrderController::class, 'getOrderInventory'])->name('get.order.inventory');


Route::get('/get-passes', [OrderController::class, 'get_passes'])->name('get-passes');
Route::get('/gatepass/inventory/{id}', [OrderController::class, 'getGatePassInventory'])->name('gatepass.inventory');

Route::post('/gatepass/return', [OrderController::class, 'returnGatePass'])->name('gatepass-return');


//Order
Route::get('/all-menu', [MenuEstimateController::class, 'all_menu'])->name('all-menu');
Route::get('/add-menu', [MenuEstimateController::class, 'add_menu'])->name('add-menu');
Route::post('/store-menu', [MenuEstimateController::class, 'store_menu'])->name('store-menu');
Route::get('/menu-invoice/{id}', [MenuEstimateController::class, 'show'])->name('menu.invoice.show');
Route::post('/menu-estimate/confirm-order', [MenuEstimateController::class, 'confirmOrder'])->name('menu.confirm.order');
Route::get('/menu/edit-estimate/{id}', [MenuEstimateController::class, 'edit'])->name('menu.edit.estimate');
Route::put('/menu-estimate/{id}', [MenuEstimateController::class, 'update_menu'])->name('menu-estimate.update');


// Route::post('/store-product', [ProductController::class, 'store_product'])->name('store-product');
// Route::get('/edit-product/{id}', [ProductController::class, 'edit_product'])->name('edit-product');
// Route::post('/update-product/{id}', [ProductController::class, 'update_product'])->name('update-product');
// Route::get('/product-alerts', [ProductController::class, 'product_alerts'])->name('product-alerts');
// Route::get('/get-subcategories/{category}', [ProductController::class, 'getSubcategories']);
// menu Items

//warehouse
Route::get('/warehouse', [WarehouseController::class, 'warehouse'])->name('warehouse');
Route::post('/store-warehouse', [WarehouseController::class, 'store_warehouse'])->name('store-warehouse');
Route::post('/update-warehouse', [WarehouseController::class, 'update_warehouse'])->name('update-warehouse');

//supplier
Route::get('/supplier', [SupplierController::class, 'supplier'])->name('supplier');
Route::post('/store-supplier', [SupplierController::class, 'store_supplier'])->name('store-supplier');
Route::post('/update-supplier', [SupplierController::class, 'update_supplier'])->name('update-supplier');

//Staff
Route::get('/staff', [StaffController::class, 'staff'])->name('staff');
Route::post('/store-staff', [StaffController::class, 'store_staff'])->name('store-staff');
Route::post('/update-staff', [StaffController::class, 'update_staff'])->name('update-staff');

//Staff Salary 
Route::get('/StaffSalary', [StaffSalaryController::class, 'StaffSalary'])->name('StaffSalary');
Route::post('/store-StaffSalary', [StaffSalaryController::class, 'store_StaffSalary'])->name('store-StaffSalary');
Route::post('/update-StaffSalary', [StaffSalaryController::class, 'update_StaffSalary'])->name('update-StaffSalary');


//Purchase 
Route::get('/Purchase', [PurchaseController::class, 'Purchase'])->name('Purchase');
Route::get('/add-purchase', [PurchaseController::class, 'add_purchase'])->name('add-purchase');
Route::post('/store-Purchase', [PurchaseController::class, 'store_Purchase'])->name('store-Purchase');
Route::post('/update-Purchase', [PurchaseController::class, 'update_Purchase'])->name('update-Purchase');
Route::post('/purchases-payment', [PurchaseController::class, 'purchases_payment'])->name('purchases-payment');
Route::get('/get-items-by-category/{categoryId}', [PurchaseController::class, 'getItemsByCategory'])->name('get-items-by-category');

Route::get('/purchase-view/{id}', [PurchaseController::class, 'view'])->name('purchase-view');
Route::get('/purchase-return/{id}', [PurchaseController::class, 'purchase_return'])->name('purchase-return');
Route::post('/store-purchase-return', [PurchaseController::class, 'store_purchase_return'])->name('store-purchase-return');
Route::get('/all-purchase-return', [PurchaseController::class, 'all_purchase_return'])->name('all-purchase-return');
Route::post('/purchase-return-payment', [PurchaseController::class, 'purchase_return_payment'])->name('purchase-return-payment');
Route::get('/get-unit-by-product/{productId}', [PurchaseController::class, 'getUnitByProduct'])->name('get-unit-by-product');


Route::get('/purchase-return-damage-item/{id}', [PurchaseController::class, 'purchase_return_damage_item'])->name('purchase-return-damage-item');
Route::post('/store-purchase-return-damage-item', [PurchaseController::class, 'store_purchase_return_damage_item'])->name('store-purchase-return-damage-item');
Route::get('/all-purchase-return-damage-item', [PurchaseController::class, 'all_purchase_return_damage_item'])->name('all-purchase-return-damage-item');


//Sale 
Route::get('/Sale', [SaleController::class, 'Sale'])->name('Sale');
Route::get('/add-Sale', [SaleController::class, 'add_Sale'])->name('add-Sale');
Route::post('/store-Sale', [SaleController::class, 'store_Sale'])->name('store-Sale');
Route::get('/all-sales', [SaleController::class, 'all_sales'])->name('all-sales');
Route::get('/get-customer-amount/{id}', [SaleController::class, 'get_customer_amount'])->name('get-customer-amount');


// Route for downloading invoice
Route::get('/invoice/download/{id}', [SaleController::class, 'downloadInvoice'])->name('invoice.download');
Route::get('/get-product-details/{productName}', [ProductController::class, 'getProductDetails'])->name('get-product-details');


Route::get('/search-products', [ProductController::class, 'searchProducts'])->name('search-products');

Route::get('/sale-receipt/{id}', [SaleController::class, 'showReceipt'])->name('sale-receipt');


//Customer
Route::get('/customer', [CustomerController::class, 'customer'])->name('customer');
Route::post('/store-customer', [CustomerController::class, 'store_customer'])->name('store-customer');
Route::post('/update-customer', [CustomerController::class, 'update_customer'])->name('update-customer');
Route::post('/customer/recovery', [CustomerController::class, 'processRecovery'])->name('customer.recovery');
Route::get('/customer-recovires', [CustomerController::class, 'customer_recovires'])->name('customer-recovires');
Route::post('/customer/credit', [CustomerController::class, 'addCredit'])->name('customer.credit');

//Vendors
Route::get('/vendor', [VendorController::class, 'vendor'])->name('vendor');
Route::post('/store-vendor', [VendorController::class, 'store_vendor'])->name('store-vendor');
Route::post('/update-vendor', [VendorController::class, 'update_vendor'])->name('update-vendor');

Route::get('/Accountant', [AccountantController::class, 'Accountant'])->name('Accountant');
Route::post('/store-Accountant', [AccountantController::class, 'store_Accountant'])->name('store-Accountant');
Route::post('/update-Accountant', [AccountantController::class, 'update_Accountant'])->name('update-Accountant');

Route::post('/update-payment', [AccountantController::class, 'update_payment'])->name('update-payment');
Route::get('/Accountant-Ledger', [AccountantController::class, 'Accountant_Ledger'])->name('Accountant-Ledger');


Route::get('/Accountant-Expense', [AccountantController::class, 'Accountant_Expense'])->name('Accountant-Expense');
Route::post('/save-accountant-expense', [AccountantController::class, 'saveExpense'])->name('save-accountant-expense');



//category
Route::get('/item-category', [ItemCategoryController::class, 'item_category'])->name('item-category');
Route::post('/item-store-category', [ItemCategoryController::class, 'item_store_category'])->name('item-store-category');
Route::post('/item-update-category', [ItemCategoryController::class, 'item_update_category'])->name('item-update-category');

Route::get('/all-item-product', [ItemProductController::class, 'all_item_product'])->name('all-item-product');
Route::get('/add-item-product', [ItemProductController::class, 'add_item_product'])->name('add-item-product');
Route::post('/store-item-product', [ItemProductController::class, 'store_item_product'])->name('store-item-product');
Route::get('/edit-item-product/{id}', [ItemProductController::class, 'edit_item_product'])->name('edit-item-product');
Route::post('/update-item-product/{id}', [ItemProductController::class, 'update_item_product'])->name('update-item-product');
Route::get('/item-product-alerts', [ItemProductController::class, 'item_product_alerts'])->name('item-product-alerts');
Route::post('/delete-item-product', [ItemProductController::class, 'delete_item_product'])->name('delete.item-product');

// warehouse stock manage
Route::get('/warehouse-stock', [warehouseStockController::class, 'warehouse_stock'])->name('warehouse-stock');
Route::post('/store-warehouse-stock', [warehouseStockController::class, 'store_warehouse_stock'])->name('store-warehouse-stock');
Route::get('/listing-warehouse-stock', [warehouseStockController::class, 'listing_warehouse_stock'])->name('listing-warehouse-stock');
Route::get('/product-warehouse-stock', [warehouseStockController::class, 'product_warehouse_stock'])->name('product-warehouse-stock');
Route::get('/get-products-by-category', [warehouseStockController::class, 'getProductsByCategory'])->name('get-products-by-category');
Route::get('/filter-warehouse-stock', [warehouseStockController::class, 'filterWarehouseStock'])->name('filter-warehouse-stock');

Route::get('/warehouse-to-shop-stock', [warehouseStockController::class, 'warehouse_to_shop_stock'])->name('warehouse-to-shop-stock');
Route::get('/get-stock', [warehouseStockController::class, 'getStock'])->name('get-stock');
Route::post('/store-warehouse-to-shop', [warehouseStockController::class, 'store_warehouse_to_shop'])->name('store-warehouse-to-shop');
Route::post('/transfer-warehouse-stock', [warehouseStockController::class, 'transfer_warehouse_stock'])->name('transfer-warehouse-stock');
Route::get('/All-Stock-Transfer', [warehouseStockController::class, 'All_Stock_Transfer'])->name('All-Stock-Transfer');

Route::get('/get-items-by-category-product/{categoryId}', [warehouseStockController::class, 'getitemsbycategoryproduct'])->name('get-items-by-category-product');
Route::get('/get-brand-by-itemproduct/{productId}', [warehouseStockController::class, 'getunitbyitemproduct'])->name('get-brand-by-itemproduct');


Route::get('/give-order-to-vendor', [VendorController::class, 'give_order_to_vendor'])->name('give-order-to-vendor');
Route::post('/fetch-order-details', [OrderController::class, 'fetchOrderDetails'])->name('fetch-order-details');
Route::post('/assign-order-to-vendor', [OrderController::class, 'assignOrderItemsToVendor'])->name('assign-order-to-vendor');
Route::get('/vendor-orders-asigned', [OrderController::class, 'vendor_orders_asigned'])->name('vendor-orders-asigned');
Route::post('/vendor-ledger-store', [OrderController::class, 'storevendorledger'])->name('vendor.ledger.store');


Route::get('/customer-report', [ReportController::class, 'customer_report'])->name('customer-report');
Route::get('/admin/customer-report-data/{id}', [ReportController::class, 'getCustomerReportData'])->name('admin.customer.report.data');

Route::get('/vendor-report', [ReportController::class, 'vendor_report'])->name('vendor-report');
Route::post('/admin/vendor-report', [ReportController::class, 'getVendorReport'])->name('admin.vendor.report');

Route::get('/order-report', [ReportController::class, 'order_report'])->name('order-report');
Route::get('/filter-order-report', [ReportController::class, 'filter_order_report'])->name('filter-order-report');

Route::get('/purchase-report', [ReportController::class, 'purchase_report'])->name('purchase-report');
Route::get('/filter-purchase', [ReportController::class, 'filterpurchase'])->name('filter.purchase');

Route::get('/Estimated-report', [ReportController::class, 'Estimated_report'])->name('Estimated-report');
Route::get('/filter-Estimated-report', [ReportController::class, 'filter_Estimated_report'])->name('filter-Estimated-report');


Route::prefix('kitchen')->group(function () {
    Route::get('/inventory', [KitchenInventoryController::class, 'index'])->name('kitchen.inventory');
    Route::post('/add-item', [KitchenInventoryController::class, 'storeItem'])->name('kitchen-items.store');
    Route::post('/add-inventory', [KitchenInventoryController::class, 'storeInventory'])->name('inventory.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
