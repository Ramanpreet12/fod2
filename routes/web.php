<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminLoginController;
use App\Http\Controllers\Backend\DeliveryController;
use App\Http\Controllers\Backend\DeliveryLoginController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\RestaurantController;
use App\Http\Controllers\Backend\RestaurantLoginController;
use App\Http\Controllers\Backend\CustomerLoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//      // Prevent delivery boys from accessing customer dashboard
//      if (Auth::user()->role === 'delivery_boy') {
//         abort(403, 'Unauthorized access.');
//     }
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



// // Public restaurant routes
// Route::match(['get', 'post'], '/restaurant/login', [RestaurantController::class, 'restaurantLogin'])
//     ->name('restaurant.login')
//     ->middleware('guest:restaurant');  // Prevent logged-in restaurant owners from accessing login


// // Authentication routes
// Route::middleware('guest')->group(function () {
//     // Admin login
//     Route::match(['get', 'post'], '/admin/login', [AdminController::class, 'login'])->name('admin.login');
//     // Restaurant login
//     // Route::match(['get', 'post'], '/restaurant/login', [RestaurantController::class, 'restaurantLogin'])->name('restaurant.login');

//     // Customer routes
//     Route::get('/user/register', [CustomerController::class, 'showRegistrationForm'])->name('user.register');
//     Route::post('/user/register', [CustomerController::class, 'register'])->name('user.register');
//     Route::get('/user/login', [CustomerController::class, 'showLoginForm'])->name('user.login');
//     Route::post('/user/login', [CustomerController::class, 'login'])->name('user.login');

//     // Delivery registration
//     // Route::get('/delivery/register', [DeliveryController::class, 'showDeliveryRegistrationForm'])->name('delivery.register');
//     // Route::post('/delivery/register', [DeliveryController::class, 'deliveryRegister']);

//     Route::match(['get', 'post'], '/delivery/registration', [DeliveryController::class, 'showDeliveryRegistration'])->name('delivery.registration');
// });


// // Protected restaurant routes - only restaurant middleware, not auth
// Route::prefix('restaurant')->middleware(['restaurant'])->group(function () {
//     Route::get('/dashboard', [RestaurantController::class, 'dashboard'])
//         ->name('restaurant.dashboard');

//     Route::post('/logout', [RestaurantController::class, 'logout'])
//         ->name('restaurant.logout');

//     // Other restaurant routes...
// });

// // Protected routes
// Route::middleware(['auth'])->group(function () {
//     // Admin routes
//     Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
//         Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
//         // Logout route
//         Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
//         Route::resource('/restaurants', RestaurantController::class);
//         // Other admin routes...
//     });

//     // // Restaurant routes
//     // Route::middleware(['restaurant'])->prefix('restaurant')->group(function () {
//     //     Route::get('/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
//     //     // Other restaurant routes...
//     // });

//     // Customer routes
//     Route::middleware(['customer'])->prefix('customer')->group(function () {
//         Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
//         // Other customer routes...
//     });

//     // Delivery routes
//     Route::middleware(['delivery'])->prefix('delivery')->group(function () {
//         Route::get('/dashboard', [DeliveryController::class, 'dashboard'])->name('delivery.dashboard');
//         // Other delivery routes...
//     });

//     // Logout route
//     // Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// });

// Admin Routes
// Route::prefix('admin')->group(function () {
//     Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

//     Route::middleware(['auth', 'role:admin'])->group(function () {
//         Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//         Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
//     });
// });

// // Restaurant Routes
// Route::prefix('restaurant')->group(function () {
//     Route::get('login', [RestaurantLoginController::class, 'showLoginForm'])->name('restaurant.login');
//     Route::post('login', [RestaurantLoginController::class, 'login'])->name('restaurant.login.submit');

//     Route::middleware(['restaurant.auth'])->group(function () {
//         Route::get('dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
//         Route::post('logout', [RestaurantLoginController::class, 'logout'])->name('restaurant.logout');
//     });
// });

// // Delivery Routes
// Route::prefix('delivery')->group(function () {
//     Route::get('register', [DeliveryController::class, 'showRegistrationForm'])->name('delivery.register');
//     Route::post('register', [DeliveryController::class, 'register'])->name('delivery.register.submit');
//     Route::get('login', [DeliveryLoginController::class, 'showLoginForm'])->name('delivery.login');
//     Route::post('login', [DeliveryLoginController::class, 'login'])->name('delivery.login.submit');

//     Route::middleware(['delivery.auth'])->group(function () {
//         Route::get('dashboard', [DeliveryController::class, 'dashboard'])->name('delivery.dashboard');
//         Route::post('logout', [DeliveryLoginController::class, 'logout'])->name('delivery.logout');
//     });
// });

// // User Routes
// Route::get('register', [CustomerController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [CustomerController::class, 'register'])->name('register.submit');
// Route::get('login', [CustomerController::class, 'showLoginForm'])->name('login');
// Route::post('login', [CustomerController::class, 'login'])->name('login.submit');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/', [HomeController::class, 'index'])->name('home');
//     Route::post('logout', [CustomerController::class, 'logout'])->name('logout');
// });


Route::middleware('guest')->group(function () {
    // Admin Routes
    Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminLoginController::class, 'login']);

    // Restaurant Routes (login only)
    Route::get('restaurant/login', [RestaurantLoginController::class, 'showLoginForm'])->name('restaurant.login');
    Route::post('restaurant/login', [RestaurantLoginController::class, 'login']);

    // Delivery Routes
    Route::get('delivery/register', [DeliveryLoginController::class, 'showRegistrationForm'])->name('delivery.register');
    Route::post('delivery/register', [DeliveryLoginController::class, 'register']);
    Route::get('delivery/login', [DeliveryLoginController::class, 'showLoginForm'])->name('delivery.login');
    Route::post('delivery/login', [DeliveryLoginController::class, 'login']);

    // Customer Routes
    Route::get('user/register', [CustomerLoginController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('user/register', [CustomerLoginController::class, 'register']);
    Route::get('user/login', [CustomerLoginController::class, 'showLoginForm'])->name('user.login');
    Route::post('user/login', [CustomerLoginController::class, 'login']);
});

// Protected Routes
Route::middleware('admin')->group(function () {
    Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Admin restaurant management routes
    Route::resource('admin/restaurants', RestaurantController::class);
});

Route::middleware('restaurant')->group(function () {
    Route::post('restaurant/logout', [RestaurantLoginController::class, 'logout'])->name('restaurant.logout');
    Route::get('restaurant/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
});

Route::middleware('delivery')->group(function () {
    Route::post('delivery/logout', [DeliveryLoginController::class, 'logout'])->name('delivery.logout');
    Route::get('delivery/dashboard', [DeliveryController::class, 'dashboard'])->name('delivery.dashboard');
});

require __DIR__ . '/auth.php';
