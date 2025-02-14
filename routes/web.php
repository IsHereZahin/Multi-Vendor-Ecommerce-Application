<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\UserManageController;
use App\Http\Controllers\Backend\VendorOrderController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\backend\NotificationController;
use App\Http\Controllers\backend\RolePermissionController;
use App\Http\Controllers\Backend\SiteSEOController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ReviewController;
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

Route::controller(App\Http\Controllers\Frontend\BlogController::class)->group(function () {
    Route::get('/blogs', 'AllBlog')->name('all.blogs');
    Route::get('/blog/{categoryslug}', 'CategoryBlogs')->name('category.blogs');
    Route::get('/blog/{categoryslug}/{blogslug}', 'BlogDetails')->name('blog.details');
});

Route::controller(IndexController::class)->group(function () {
    Route::get('/', 'home')->name('home'); // Home route
    Route::post('/product/search', 'ProductSearch')->name('product.search');
    Route::post('Ajax/search', 'AjaxProductSearch')->name('ajax.product.search');

    // Product View Details Route
    Route::get('/product-details/{id}/{slug}',  'ProductDetails')->name('product.details');
    Route::get('/category/{id}/{slug}',  'CategoryProduct')->name('category.products');
    Route::get('/subcategory/{id}/{slug}',  'SubCategoryProduct')->name('subcategory.products');
});

// All Vendor
Route::get('/all/vendors', [VendorController::class, 'AllVendor'])->name('all.vendors');
Route::get('/vendor/details/{id}', [VendorController::class, 'VendorDetails'])->name('vendor.details');

// Brand
Route::get('/brands', [App\Http\Controllers\Frontend\BrandController::class, 'brands'])->name('brands');
Route::get('/brand/{id}', [App\Http\Controllers\Frontend\BrandController::class, 'brand_show'])->name('brand.show');

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        // Dashboard and Profile Update Routes
        Route::get('/dashboard', 'UserDashboard')->name('dashboard');
        Route::post('/user/profile/update', 'UserProfileUpdate')->name('user.profile.update');
        Route::post('/user/password/update', 'UserPasswordUpdate')->name('user.password.update');

        // Additional User Routes
        Route::get('/user/orders/{status?}', 'UserOrders')->name('user.orders');
        Route::get('/order/{invoice_id}', 'UserOrderDetails')->name('user.order.details');
        Route::get('/download-invoice/{orderId}', 'DownloadInvoice')->name('order.downloadInvoice');

        Route::post('/user/order/cancel/{id}','cancelOrder')->name('user.cancel.order');
        Route::post('/order/return/{id}', 'returnOrder')->name('user.return.order');

        Route::get('/track-orders', 'UserTrackOrders')->name('user.track.orders');
        Route::post('/track-order', 'UserTrackOrderDetails')->name('user.track.order');
        Route::get('/account-details', 'UserAccountDetails')->name('user.account.details');
        Route::get('/change-password', 'UserChangePassword')->name('user.change.password');
    });
});

// Admin routes
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class);
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Admin routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dashboard');
        Route::get('/admin/logout', 'AdminLogout')->name('admin.logout');
        Route::get('/admin/profile', 'AdminProfile')->name('admin.profile');
        Route::get('/admin/change/password', 'AdminChangePassword')->name('admin.change.password');
        Route::post('/admin/password/update', 'AdminPasswordUpdate')->name('admin.password.update');
        Route::post('/admin/profile/update', 'AdminProfileUpdate')->name('admin.profile.update');

        // All Admin
        Route::get('/admin/all/admins', 'AllAdmins')->name('all.admins');
        Route::get('/admin/add/admin', 'AddAdmin')->name('add.admin');
        Route::post('/admin/store/admin', 'StoreAdmin')->name('store.admin');
        Route::get('/admin/edit/admin/{id}', 'EditAdmin')->name('edit.admin');
        Route::put('/admin/update/admin/{id}', 'UpdateAdmin')->name('update.admin');
        Route::get('/admin/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');
    });

    // Users manage routes
    Route::controller(UserManageController::class)->group(function () {
        // Active InActive Validation Routes
        Route::get('/inactive/vendor', 'InactiveVendor')->name('inactive.vendor');
        Route::get('/inactive/vendor/details/{id}', 'InactiveVendorDetails')->name('inactive.vendor.details');
        Route::post('/active/vendor/approve', 'ActiveVendorApprove')->name('active.vendor.approve');
        Route::get('/active/vendor', 'ActiveVendor')->name('active.vendor');
        Route::get('/active/vendor/details/{id}', 'ActiveVendorDetails')->name('active.vendor.details');
        Route::post('/inactive/vendor/approve', 'InActiveVendorApprove')->name('inactive.vendor.approve');

        // User routes
        Route::get('all/users', 'AllUsers')->name('all.users');
    });

    // Blog routes
    Route::prefix('admin/blog/categories')->name('admin.blog.category.')->controller(BlogCategoryController::class)->group(function () {
        // Blog Category Routes
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'destroy')->name('delete');
    });

    Route::prefix('admin/blog')->name('admin.blog.')->controller(BlogController::class)->group(function () {
        // Blog Routes
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'destroy')->name('delete');
    });

    // Brand routes
    Route::controller(BrandController::class)->group(function () {
        Route::get('all/brand', 'AllBrand')->name('all.brand');
        Route::get('add/brand', 'AddBrand')->name('add.brand');
        Route::post('store/brand', 'StoreBrand')->name('store.brand');
        Route::get('/brand/edit/{id}', 'EditBrand')->name('edit.brand');
        Route::put('/brand/{id}', 'UpdateBrand')->name('update.brand');
        Route::delete('/brand/delete/{id}', 'DeleteBrand')->name('delete.brand');
    });

    // Category routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('all/category', 'AllCategory')->name('all.category');
        Route::get('add/category', 'AddCategory')->name('add.category');
        Route::post('store/category', 'StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::put('/category/{id}', 'UpdateCategory')->name('update.category');
        Route::delete('/category/delete/{id}', 'DeleteCategory')->name('delete.category');
    });

    // Sub Category routes
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('all/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('store/subcategory', 'StoreSubCategory')->name('store.subcategory');
        Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::put('/subcategory/{id}', 'UpdateSubCategory')->name('update.subcategory');
        Route::delete('/subcategory/delete/{id}', 'DeleteSubCategory')->name('delete.subcategory');
        Route::get('/get-subcategories/{categoryId}', 'getSubcategories')->name('get.Subcategories');
    });

    // Product All Route
    Route::controller(ProductController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/store/product', 'StoreProduct')->name('store.product');
        Route::get('/product/edit/{id}', 'EditProduct')->name('edit.product');
        Route::post('/product/update/{id}', 'updateProduct')->name('update.product');
        Route::get('/product/delete/{id}', 'DeleteProduct')->name('delete.product');

        // Improved route naming conventions
        Route::post('/product/inactive/approve', 'InactiveProductApprove')->name('inactive.product.approve');
        Route::post('/product/active/approve', 'ActiveProductApprove')->name('active.product.approve');
    });

    // Home Slider routes
    Route::controller(SliderController::class)->group(function () {
        Route::get('all/slider', 'AllSlider')->name('all.slider');
        Route::get('add/slider', 'AddSlider')->name('add.slider');
        Route::post('store/slider', 'StoreSlider')->name('store.slider');
        Route::get('/slider/edit/{id}', 'EditSlider')->name('edit.slider');
        Route::put('/slider/{id}', 'UpdateSlider')->name('update.slider');
        Route::delete('/slider/delete/{id}', 'DeleteSlider')->name('delete.slider');
    });

    // Banner routes
    Route::controller(BannerController::class)->group(function () {
        Route::get('all/banner', 'AllBanner')->name('all.banner');
        Route::get('add/banner', 'AddBanner')->name('add.banner');
        Route::post('store/banner', 'StoreBanner')->name('store.banner');
        Route::get('/banner/edit/{id}', 'EditBanner')->name('edit.banner');
        Route::put('/banner/{id}', 'UpdateBanner')->name('update.banner');
        Route::delete('/banner/delete/{id}', 'DeleteBanner')->name('delete.banner');
    });

    // Coupon routes
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
        Route::put('/division/update/{id}', 'UpdateDivision')->name('update.division');
        Route::delete('division/delete/{id}', 'DeleteDivision')->name('delete.division');

        // District routes
        Route::get('all/district', 'AllDistricts')->name('all.district');
        Route::post('store/district', 'StoreDistrict')->name('store.district');
        Route::put('/district/update/{id}', 'UpdateDistrict')->name('update.district');
        Route::delete('/district/delete/{id}', 'DeleteDistrict')->name('delete.district');

        // State routes
        Route::get('all/state', 'AllState')->name('all.state');
        Route::post('store/state', 'StoreState')->name('store.state');
        Route::put('/state/update/{id}', 'UpdateState')->name('update.state');
        Route::delete('/state/delete/{id}', 'DeleteState')->name('delete.state');
    });

    // Order routes
    Route::controller(OrderController::class)->group(function () {
        Route::get('/admin/orders/{status}', 'AdminOrdersByStatus')->name('admin.orders.by.status');
        Route::get('/admin/order/details/{id}', 'AdminOrderDetails')->name('admin.order.details');

        // status updates
        Route::get('/admin/confirmed/order/{id}', 'AdminConfirmedOrder')->name('admin.confirmed.order');
        Route::get('/admin/processing/order/{id}', 'AdminProcessingOrder')->name('admin.processing.order');
        Route::get('/admin/picked/order/{id}', 'AdminPickedOrder')->name('admin.picked.order');
        Route::get('/admin/shipped/order/{id}', 'AdminShippedOrder')->name('admin.shipped.order');
        Route::get('/admin/delivered/order/{id}', 'AdminDeliveredOrder')->name('admin.delivered.order');
        Route::post('admin/orders/{order}/return-accept', 'acceptReturn')->name('admin.return.accept');

        // Order Report
        Route::get('/admin/order/report', 'AdminOrderReport')->name('admin.order.report');
    });

    // Product review
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/admin/all/review', 'AdminReview')->name('admin.review');
        Route::get('admin/review/toggle/{id}', 'AdminToggleReviewStatus')->name('admin.review.toggle');
        Route::delete('admin/review/delete/{id}', 'AdminDeleteReview')->name('admin.review.delete');
    });

    // Site Setting
    Route::controller(SiteSettingController::class)->group(function () {
        Route::get('/admin/site/setting', 'AdminSiteSetting')->name('admin.site.setting');
        Route::post('/admin/site/setting', 'UpdateSiteSetting')->name('admin.site.setting.update');
        Route::get('/admin/site/setting/reset', 'ResetSiteSetting')->name('admin.site.setting.reset');
    });

    // Site SEO
    Route::controller(SiteSEOController::class)->group(function () {
        Route::get('/admin/seo/setting', 'AdminSeoSetting')->name('admin.seo.setting');
        Route::post('/admin/seo/setting', 'UpdateSeoSetting')->name('admin.seo.setting.update');
        Route::get('/admin/seo/setting/reset', 'ResetSeoSetting')->name('admin.seo.setting.reset');
    });

    // Role Permission Management
    Route::controller(RolePermissionController::class)->group(function () {
        // Permission routes
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/permission/create', 'CreatePermission')->name('create.permission');
        Route::post('/permission/store', 'StorePermission')->name('store.permission');
        Route::get('/permission/edit/{id}', 'EditPermission')->name('edit.permission');
        Route::put('/permission/update/{id}', 'UpdatePermission')->name('update.permission');
        Route::delete('/permission/delete/{id}', 'DeletePermission')->name('delete.permission');

        // Roles in Permission
        Route::get('/role/permission/index', 'IndexRolePermission')->name('index.role.permission');
        Route::get('/role/permission/create', 'CreateRolePermission')->name('create.role.permission');
        Route::post('/role/permission/store', 'StoreRolePermission')->name('store.role.permission');
        Route::get('/role/permission/edit/{id}', 'EditRolePermission')->name('edit.role.permission');
        Route::put('/role/permission/edit/{id}', 'UpdateRolePermission')->name('update.role.permission');
        Route::delete('/role/permission/delete/{id}', 'DeleteRolePermission')->name('delete.role.permission');
    });
});

// Vendor routes
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login')->middleware(RedirectIfAuthenticated::class);
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');


// Vendor routes
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorLogout'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/password/update', [VendorController::class, 'VendorPasswordUpdate'])->name('vendor.password.update');
    Route::post('/vendor/profile/update', [VendorController::class, 'VendorProfileUpdate'])->name('vendor.profile.update');

    Route::middleware(['status:active'])->group(function () {
        // Vendor Manage Route
        Route::controller(VendorProductController::class)->group(function () {
            Route::get('/vendor/all/product', 'VendorAllProduct')->name('vendor.all.product');
            Route::get('/vendor/add/product', 'VendorAddProduct')->name('vendor.add.product');
            Route::post('/vendor/store/product', 'VendorStoreProduct')->name('vendor.store.product');
            Route::get('/vendor/product/edit/{id}', 'VendorEditProduct')->name('vendor.edit.product');
            Route::post('/vendor/product/update/{id}', 'VendorUpdateProduct')->name('vendor.update.product');
            Route::get('/vendor/product/delete/{id}', 'VendorDeleteProduct')->name('vendor.delete.product');

            Route::get('/vendor/subcategory/ajax/{category_id}', 'VendorGetSubCategory')->name('vendor.get.subcategory');

            // Improved route naming conventions
            Route::post('/vendor/product/inactive/approve', 'VendorInactiveProductApprove')->name('vendor.inactive.product.approve');
            Route::post('/vendor/product/active/approve', 'VendorActiveProductApprove')->name('vendor.active.product.approve');
        });
    });

    // Vendor Order Route
    Route::controller(VendorOrderController::class)->group(function () {
        Route::get('/vendor/orders/{status}', 'vendorOrdersByStatus')->name('vendor.orders.by.status');
        Route::get('/vendor/order/details/{id}', 'VendorOrderDetails')->name('vendor.order.details');
    });

    // Product review
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/vendor/all/review', 'VendorReview')->name('vendor.review');
        Route::get('vendor/review/toggle/{id}', 'VendorToggleReviewStatus')->name('vendor.review.toggle');
        Route::delete('vendor/review/delete/{id}', 'VendorDeleteReview')->name('vendor.review.delete');
    });
});

// Cart and Wishlist Routes
Route::middleware('auth')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart/index', 'index')->name('cart.index');
        Route::post('/cart/add', 'addToCart')->name('cart.add');
        Route::get('/cart/data', 'getCartData')->name('cart.data');
        Route::get('/minicart/product/remove/{id}', 'removeItem')->name('minicart.remove');
        Route::get('/cart/clear', 'clearCart')->name('cart.clear');
        Route::post('/cart/increment/{id}', 'CartIncrement')->name('cart.increment');
        Route::post('/cart/decrement/{id}', 'CartDecrement')->name('cart.decrement');
        Route::patch('/cart/{id}', 'update')->name('cart.update');
        Route::post('/coupon-apply', 'CouponApply')->name('coupon.apply');
        Route::post('/coupon-remove', 'CouponRemove')->name('coupon.remove');
    });

    Route::controller(WishlistController::class)->group(function () {
        Route::post('/wishlist/toggle/{productId}', 'toggleWishlist')->name('wishlist.toggle');
        Route::get('/wishlist', 'index')->name('wishlist.index');
    });

    // Get shipping address
    Route::controller(ShippingAreaController::class)->group(function () {
        Route::get('/get-districts/{division_id}', 'getDistricts');
        Route::get('/get-states/{district_id}', 'getStates');
    });

    // Check-Out route
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/checkout', 'checkout')->name('checkout');
        Route::post('/checkout/store', 'CheckoutStore')->name('checkout.store');
    });

    // Check-Out route
    Route::controller(PaymentController::class)->group(function () {
        Route::post('/stripe/order', 'StripeOrder')->name('stripe.order');
        Route::post('/cash-on-delivery/order', 'cashOnDeliveryOrder')->name('cash.on.delivery.order');
    });

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // notification Route
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notification/mark-as-read/{id}', 'markAsRead')->name('notification.markAsRead');
        Route::get('/notifications/mark-all-as-read', 'markAllAsRead')->name('notifications.markAllAsRead');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
