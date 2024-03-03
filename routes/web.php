<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\ContactController;

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
    return view('welcome');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

Route::resource('contacts', ContactController::class)->middleware(auth::class);
Route::post('contacts/orderby-contacts', [ContactController::class, 'OrderBy'])->middleware(auth::class);
Route::post('contacts/search-contacts', [ContactController::class, 'search_contacts'])->middleware(auth::class);

//========================================================================//
//=============================== Admin Routes============================//
//========================================================================//

Route::name('admin.')->prefix('admin')->middleware('admin_web')->group( function () {
    Route::get('/login', 'App\Http\Controllers\Admin\LoginController@login')->name('login');
    Route::post('/authenticate', 'App\Http\Controllers\Admin\LoginController@authenticate')->name('authenticate');
});

Route::name('admin.')->prefix('admin')->middleware('is_admin')->group( function () {
    Route::get('/', 'App\Http\Controllers\Admin\AdminController@dashboard')->name('dashboard');
    Route::post('/logout', 'App\Http\Controllers\Admin\AdminController@logout')->name('logout');
    Route::get('/orders', 'App\Http\Controllers\Admin\OrderController@index')->name('orders');
    Route::get('/order/create', 'App\Http\Controllers\Admin\OrderController@create')->name('create');
    Route::post('/order/store', 'App\Http\Controllers\Admin\OrderController@store')->name('store');
    Route::get('/order/show/{id}', 'App\Http\Controllers\Admin\OrderController@show')->name('show');
});
