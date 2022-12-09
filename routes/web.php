<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MultiImageController;
use App\Http\Controllers\SliderController;
use App\Models\User;
use App\Models\Brand;

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

Route::get('/', function () {
    $brands = Brand::latest()->get();
    return view('home', compact('brands'));
});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::get('/user/logout', function () {
    return view('welcome');
});

Route::get('/user/logout', [SettingsController::class, 'logout_user'])->name('user.logout');

//Category controller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');

Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('persist.category');

Route::get('/category/edit/{id}', [CategoryController::class, 'EditCat']);

Route::post('/category/update/{id}', [CategoryController::class, 'UpdateCat']);

Route::get('/softdelete/category/{id}', [CategoryController::class, 'SoftdeleteCat']);

Route::get('/category/restore/{id}', [CategoryController::class, 'RestoreCat']);

Route::get('/permanent_delete/category/{id}', [CategoryController::class, 'PermanentdeleteCat']);


//Brand controller
Route::get('/all/brands', [BrandController::class, 'AllBrands'])->name('all.brands');

Route::post('/brand/add', [BrandController::class, 'AddBrand'])->name('persist.brand');

Route::get('/brand/edit/{id}', [BrandController::class, 'EditBrand']);

Route::post('/brand/update/{id}', [BrandController::class, 'UpdateBrand']);

Route::get('/softdelete/brand/{id}', [BrandController::class, 'SoftdeleteBrand']);

Route::get('/brand/restore/{id}', [BrandController::class, 'RestoreBrand']);

Route::get('/permanent_delete/brand/{id}', [BrandController::class, 'PermanentdeleteBrand']);


//Multi-Images Controller Routes
Route::get('/all/images', [MultiImageController::class, 'AllImages'])->name('all.images');

Route::post('/multi-images/add', [MultiImageController::class, 'AddMultiImages'])->name('persist.images');


//Slider Controller Routes
Route::get('/all/sliders', [SliderController::class, 'AllSliders'])->name('all.sliders');

Route::post('/slider/add', [SliderController::class, 'AddSlider'])->name('persist.slider');

Route::get('/slider/edit/{id}', [SliderController::class, 'EditSlider']);

Route::post('/slider/update/{id}', [SliderController::class, 'UpdateSlider']);

Route::get('/softdelete/slider/{id}', [SliderController::class, 'SoftdeleteSlider']);

Route::get('/slider/restore/{id}', [SliderController::class, 'RestoreSlider']);

Route::get('/permanent_delete/slider/{id}', [SliderController::class, 'PermanentdeleteSlider']);