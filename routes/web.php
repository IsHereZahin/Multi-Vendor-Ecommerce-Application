<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
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

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

// Admin routes
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');

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
        Route::get('/category/edit/{id}', 'EditCategory')->name('edit.category');
        Route::put('/category/{id}', 'UpdateCategory')->name('update.category');
        Route::delete('/category/delete/{id}', 'DeleteCategory')->name('delete.category');
    });

    // Sub Category routes
    Route::controller(SubCategoryController::class)->group(function() {
        Route::get('all/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('add/subcategory', 'AddSubCategory')->name('add.subcategory');
        Route::post('store/subcategory', 'StoreSubCategory')->name('store.subcategory');
        Route::get('/subcategory/edit/{id}', 'EditSubCategory')->name('edit.subcategory');
        Route::put('/subcategory/{id}', 'UpdateSubCategory')->name('update.subcategory');
        Route::delete('/subcategory/delete/{id}', 'DeleteSubCategory')->name('delete.subcategory');
    });
});

// Vendor routes
Route::get('/vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login');
Route::get('/become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorLogout'])->name('vendor.logout');
    Route::get('/vendor/profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::get('/vendor/change/password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
    Route::post('/vendor/password/update', [VendorController::class, 'VendorPasswordUpdate'])->name('vendor.password.update');
    Route::post('/vendor/profile/update', [VendorController::class, 'VendorProfileUpdate'])->name('vendor.profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
