<?php

use App\Http\Controllers\Admin\AdminController ;
// use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\SubCategoryController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Vendor\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUser;
use App\Http\Middleware\IsValidEmail;
use App\Http\Middleware\isVendor;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    
    // Verify Email
    
    Route::post('/auth/verifyemail', [AuthController::class, 'verifyemail']);

});

Route::group(['middleware' => ['auth:sanctum' , IsValidEmail::class]], function () {
    // Profile

        // get Profile
        Route::get('/profile', [AuthController::class, 'profile']);

        // Update Profile
        Route::post('/profile/update', [AuthController::class, 'updateProfile']);
        
        // who
        Route::get('/who', [AuthController::class, 'who']);
    
    //

    


    // logout
        Route::post('/auth/logout', [AuthController::class, 'logout']);
    // 

});




// Admin

Route::post('/admin/login', [AdminController::class, 'login']);

Route::group([ 'prefix' => "/admin", 'middleware' => ['auth:sanctum' , isAdmin::class , IsValidEmail::class]], function () {

    // profile 
    Route::get('/profile', [AdminController::class , 'profile']);
    Route::post('/profile/update', [AdminController::class , 'updateProfile']);

    // Category
    Route::apiResource('/categories' , CategoryController::class);

    // SubCategory
    Route::apiResource('/subcategories' , SubCategoryController::class);

    
    
    // logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});




// Vendor
Route::post('/vendor/login', [VendorController::class, 'login']);
Route::post('/vendor/register', [VendorController::class, 'register']);

Route::group([ 'prefix' => "/vendor", 'middleware' => ['auth:sanctum' , isVendor::class , IsValidEmail::class]], function () {

    // profile 
    Route::get('/profile', [VendorController::class , 'profile']);
    Route::post('/profile/update', [VendorController::class , 'updateProfile']);

    
    // logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});




// User

Route::post('user/register', [UserController::class, 'register']);


Route::group([ 'prefix' => "/user", 'middleware' => ['auth:sanctum' , isUser::class]], function () {


    // Registration



    // profile 
    Route::get('/profile', [UserController::class , 'profile']);
    Route::post('/profile/update', [UserController::class , 'updateProfile']);

    
    // logout
    Route::post('/auth/logout', [UserController::class, 'logout']);
});



// Categories
Route::group([ 'prefix' => "/categories"], function () {
    // All Categories
    Route::get('/', [CategoryController::class, 'index']);
    // Single Category
    Route::get('/{id}', [CategoryController::class, 'show']);
});


// Sub Categories
Route::group([ 'prefix' => "/subcategories"], function () {
    // All Categories
    Route::get('/', [SubCategoryController::class, 'index']);
    // Single Category
    Route::get('/{id}', [SubCategoryController::class, 'show']);
});



// Sub Categories
Route::group([ 'prefix' => "/store"], function () {
    // All store
    Route::get('/all', [StoreController::class, 'index']);
    // My Store
    Route::get('/my', [StoreController::class, 'mystore'])->middleware(['auth:sanctum']);
    // Single store
    Route::get('/{id}', [StoreController::class, 'show']);


    // Add Store With one Active limit only 
    Route::patch('/{id}', [StoreController::class, 'update'])->middleware(['auth:sanctum']);

     // Add Store With one Active limit only 
     Route::post('/create', [StoreController::class, 'store'])->middleware(['auth:sanctum']);
    
});
