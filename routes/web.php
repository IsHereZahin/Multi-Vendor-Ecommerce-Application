<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\ShippingAreaController;

use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\RedirectIfAuthenticated;
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

Route::get('/', function () {
    return view('frontend.index');
});

// Product View Details Route
Route::get('/product-details/{id}/{slug}', [IndexController::class, 'ProductDetails'])->name('product.details');
Route::get('/category/{id}/{slug}', [IndexController::class, 'CategoryProduct'])->name('category.products');
Route::get('/subcategory/{id}/{slug}', [IndexController::class, 'SubCategoryProduct'])->name('subcategory.products');

// Add to cart routes


// All Vendor
Route::get('/all/vendors', [VendorController::class, 'AllVendor'])->name('all.vendors');
Route::get('/vendor/details/{id}', [VendorController::class, 'VendorDetails'])->name('vendor.details');

// Brand
Route::get('/brands', [App\Http\Controllers\Frontend\BrandController::class, 'brands'])->name('brands');
Route::get('/brand/{id}', [App\Http\Controllers\Frontend\BrandController::class, 'brand_show'])->name('brand.show');

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

// Admin routes
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');

    // Active InActive Validation Routes
    Route::get('/inactive/vendor', [AdminController::class, 'InactiveVendor'])->name('inactive.vendor');
    Route::get('/inactive/vendor/details/{id}', [AdminController::class, 'InactiveVendorDetails'])->name('inactive.vendor.details');
    Route::post('/active/vendor/approve', [AdminController::class, 'ActiveVendorApprove'])->name('active.vendor.approve');
    Route::get('/active/vendor' , [AdminController::class, 'ActiveVendor'])->name('active.vendor');
    Route::get('/active/vendor/details/{id}' , [AdminController::class, 'ActiveVendorDetails'])->name('active.vendor.details');
    Route::post('/inactive/vendor/approve' , [AdminController::class, 'InActiveVendorApprove'])->name('inactive.vendor.approve');

    // Brand routes
    Route::controller(BrandController::class)->group(function() {
        Route::get('all/brand', 'AllBrand')->name('all.brand');
        Route::get('add/brand', 'AddBrand')->name('add.brand');
        Route::post('store/brand', 'StoreBrand')->name('store.brand');
        Route::get('/brand/edit/{id}', 'EditBrand')->name('edit.brand');
        Route::put('/brand/{id}', 'UpdateBrand')->name('update.brand');
        Route::delete('/brand/delete/{id}', 'DeleteBrand')->name('delete.brand');
    });

    // Category routes
    Route::controller(CategoryController::class)->group(function() {
        Route::get('all/category', 'AllCategory')->name('all.category');
        Route::get('add/category', 'AddCategory')->name('add.category');
        Route::post('store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::put('/category/{id}', 'UpdateCategory')->name('update.category');
        Route::delete('/category/delete/{id}', 'DeleteCategory')->name('delete.category');
    });

    // Sub Category routes
    Route::controller(SubCategoryController::class)->group(function() {
        Route::get('all/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('store/subcategory', 'StoreSubCategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::put('/subcategory/{id}', 'UpdateSubCategory')->name('update.subcategory');
        Route::delete('/subcategory/delete/{id}', 'DeleteSubCategory')->name('delete.subcategory');
        Route::get('/get-subcategories/{categoryId}' , 'getSubcategories')->name('get.Subcategories');
    });

     // Product All Route
    Route::controller(ProductController::class)->group(function(){
        Route::get('/all/product' , 'AllProduct')->name('all.product');
        Route::get('/add/product' , 'AddProduct')->name('add.product');
        Route::post('/store/product' , 'StoreProduct')->name('store.product');
        Route::get('/product/edit/{id}' , 'EditProduct')->name('edit.product');
        Route::post('/product/update/{id}' , 'updateProduct')->name('update.product');
        Route::get('/product/delete/{id}' , 'DeleteProduct')->name('delete.product');

        // Improved route naming conventions
        Route::post('/product/inactive/approve', 'InactiveProductApprove')->name('inactive.product.approve');
        Route::post('/product/active/approve', 'ActiveProductApprove')->name('active.product.approve');
    });


    // Home Slider routes
    Route::controller(SliderController::class)->group(function() {
        Route::get('all/slider', 'AllSlider')->name('all.slider');
        Route::get('add/slider', 'AddSlider')->name('add.slider');
        Route::post('store/slider', 'StoreSlider')->name('store.slider');
        Route::get('/slider/edit/{id}', 'EditSlider')->name('edit.slider');
        Route::put('/slider/{id}', 'UpdateSlider')->name('update.slider');
        Route::delete('/slider/delete/{id}', 'DeleteSlider')->name('delete.slider');
    });

    // Banner routes
    Route::controller(BannerController::class)->group(function() {
        Route::get('all/banner', 'AllBanner')->name('all.banner');
        Route::get('add/banner', 'AddBanner')->name('add.banner');
        Route::post('store/banner', 'StoreBanner')->name('store.banner');
        Route::get('/banner/edit/{id}', 'EditBanner')->name('edit.banner');
        Route::put('/banner/{id}', 'UpdateBanner')->name('update.banner');
        Route::delete('/banner/delete/{id}', 'DeleteBanner')->name('delete.banner');
    });

    Route::controller(CouponController::class)->group(function () {
        Route::get('all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('store/coupon', 'StoreCoupon')->name('store.coupon');
        Route::get('/coupon/edit/{id}', 'EditCoupon')->name('edit.coupon');
        Route::put('/coupon/update/{id}', 'UpdateCoupon')->name('update.coupon');
        Route::delete('/coupon/delete/{id}', 'DeleteCoupon')->name('delete.coupon');
    });

    // Shipping Area Routes
    Route::controller(ShippingAreaController::class)->group(function () {
        // Division routes
        Route::get('all/division', 'AllDivision')->name('all.division');
        Route::post('store/division', 'StoreDivision')->name('store.division');
        Route::put('/division/update/{id}','UpdateDivision')->name('update.division');
        Route::delete('division/delete/{id}', 'DeleteDivision')->name('delete.division');

        // District routes
        Route::get('all/district', 'AllDistricts')->name('all.district');
        Route::post('store/district', 'StoreDistrict')->name('store.district');
        Route::put('/district/update/{id}', 'UpdateDistrict')->name('update.district');
        Route::delete('/district/delete/{id}', 'DeleteDistrict')->name('delete.district');

        // State routes
        Route::get('all/state', 'AllState')->name('all.state');
        Route::get('/get-districts/{division_id}','getDistricts');
        Route::post('store/state', 'StoreState')->name('store.state');
        Route::put('/state/update/{id}', 'UpdateState')->name('update.state');
        Route::delete('/state/delete/{id}', 'DeleteState')->name('delete.state');
    });
});

// Vendor routes
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorLogout'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/password/update', [VendorController::class, 'VendorPasswordUpdate'])->name('vendor.password.update');
    Route::post('/vendor/profile/update', [VendorController::class, 'VendorProfileUpdate'])->name('vendor.profile.update');

    Route::middleware(['status:active'])->group(function () {
        // Product All Route
        Route::controller(VendorProductController::class)->group(function(){
            Route::get('/vendor/all/product' , 'VendorAllProduct')->name('vendor.all.product');
            Route::get('/vendor/add/product' , 'VendorAddProduct')->name('vendor.add.product');
            Route::post('/vendor/store/product' , 'VendorStoreProduct')->name('vendor.store.product');
            Route::get('/vendor/product/edit/{id}' , 'VendorEditProduct')->name('vendor.edit.product');
            Route::post('/vendor/product/update/{id}' , 'VendorUpdateProduct')->name('vendor.update.product');
            Route::get('/vendor/product/delete/{id}' , 'VendorDeleteProduct')->name('vendor.delete.product');

            Route::get('/vendor/subcategory/ajax/{category_id}' , 'VendorGetSubCategory')->name('vendor.get.subcategory');

            // Improved route naming conventions
            Route::post('/vendor/product/inactive/approve', 'VendorInactiveProductApprove')->name('vendor.inactive.product.approve');
            Route::post('/vendor/product/active/approve', 'VendorActiveProductApprove')->name('vendor.active.product.approve');
        });
    });
});

// Add routes for cart
Route::middleware('auth')->group(function () {
    Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
    Route::get('/minicart/product/remove/{id}', [CartController::class, 'removeItem'])->name('minicart.remove');
    Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/cart/increment/{id}', [CartController::class, 'CartIncrement'])->name('cart.increment');
    Route::post('/cart/decrement/{id}', [CartController::class, 'CartDecrement'])->name('cart.decrement');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
});

// Wishlist routes
Route::middleware(['auth'])->group(function () {
    Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

// web.php
Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
