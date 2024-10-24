<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\DeliveryController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\RestaurantController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//      // Prevent delivery boys from accessing customer dashboard
//      if (Auth::user()->role === 'delivery_boy') {
//         abort(403, 'Unauthorized access.');
//     }
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



// Public restaurant routes
Route::match(['get', 'post'], '/restaurant/login', [RestaurantController::class, 'restaurantLogin'])
    ->name('restaurant.login')
    ->middleware('guest:restaurant');  // Prevent logged-in restaurant owners from accessing login


// Authentication routes
Route::middleware('guest')->group(function () {
    // Admin login
    Route::match(['get', 'post'], '/admin/login', [AdminController::class, 'login'])->name('admin.login');
    // Restaurant login
    // Route::match(['get', 'post'], '/restaurant/login', [RestaurantController::class, 'restaurantLogin'])->name('restaurant.login');

    // Customer routes
    Route::get('/register', [CustomerController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [CustomerController::class, 'register']);
    Route::get('/login', [CustomerController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerController::class, 'login']);

    // Delivery registration
    // Route::get('/delivery/register', [DeliveryController::class, 'showDeliveryRegistrationForm'])->name('delivery.register');
    // Route::post('/delivery/register', [DeliveryController::class, 'deliveryRegister']);

    Route::match(['get', 'post'], '/delivery/registration', [DeliveryController::class, 'showDeliveryRegistration'])->name('delivery.registration');
});


// Protected restaurant routes - only restaurant middleware, not auth
Route::prefix('restaurant')->middleware(['restaurant'])->group(function () {
    Route::get('/dashboard', [RestaurantController::class, 'dashboard'])
        ->name('restaurant.dashboard');

    Route::post('/logout', [RestaurantController::class, 'logout'])
        ->name('restaurant.logout');

    // Other restaurant routes...
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        // Logout route
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::resource('/restaurants', RestaurantController::class);
        // Other admin routes...
    });

    // // Restaurant routes
    // Route::middleware(['restaurant'])->prefix('restaurant')->group(function () {
    //     Route::get('/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
    //     // Other restaurant routes...
    // });

    // Customer routes
    Route::middleware(['customer'])->prefix('customer')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        // Other customer routes...
    });

    // Delivery routes
    Route::middleware(['delivery'])->prefix('delivery')->group(function () {
        Route::get('/dashboard', [DeliveryController::class, 'dashboard'])->name('delivery.dashboard');
        // Other delivery routes...
    });

    // Logout route
    // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
require __DIR__ . '/auth.php';
