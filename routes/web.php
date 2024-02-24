<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Staff\LoginController;
use App\Http\Controllers\Staff\DashboardController;

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

// Route::get('/', function () {
   // return view('welcome');
// });

Route::get('/reservation-mail', function () {
   
   return view('content.reservation')->with([ 'name' => '' ]); 
});


Route::get('/sec-leve-notification', 'App\Http\Controllers\IndexHomeController@notifyAdminForSecLevel')->name('secLevel');


Auth::routes();

// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

/*================================================================================
                            FRONTEND PAGE ROUTING
=================================================================================*/

Route::get('/landing/en', 'App\Http\Controllers\LandingController@index_en');
Route::get('/landing/jp', 'App\Http\Controllers\LandingController@index_jp');
Route::get('/', 'App\Http\Controllers\IndexHomeController@index');
Route::get('/en', 'App\Http\Controllers\IndexHomeController@index2');
Route::get('/home', 'App\Http\Controllers\IndexHomeController@index');
Route::get('/food-service', 'App\Http\Controllers\IndexHomeController@foodNService');
Route::get('/food-service-jp', 'App\Http\Controllers\IndexHomeController@foodNServiceJp');
Route::get('/about', 'App\Http\Controllers\AboutController@about');
Route::get('/menu', 'App\Http\Controllers\MenuController@menu');
Route::get('/order', 'App\Http\Controllers\OrderController@order');
Route::get('/reservation', 'App\Http\Controllers\ReservationController@reservation');
Route::get('/contact', 'App\Http\Controllers\ContactController@contact');

Route::post('/storeorder', 'App\Http\Controllers\OrderController@storeorder')->name('storeorder.submit');

/*================================================================================
                            FRONTEND INSERT FUNCTION ROUTING
=================================================================================*/

Route::post('/doreservation', 'App\Http\Controllers\ReservationController@doreservation')->name('doreservation.submit');
Route::post('/docontact', 'App\Http\Controllers\ContactController@docontact')->name('docontact.submit');



/*================================================================================
                            ADMIN DASHBOARD PAGE ROUTING
=================================================================================*/

Route::get('/dashboard', 'App\Http\Controllers\Admin\DashbaordController@dashboard');
Route::get('/expense', 'App\Http\Controllers\Admin\ExpenseController@expense');
Route::get('/dashmenu', 'App\Http\Controllers\Admin\DashMenuController@dashmenu');
Route::get('/message', 'App\Http\Controllers\Admin\MessageController@message');
Route::get('/newadmin', 'App\Http\Controllers\Admin\NewAdminController@newadmin');
Route::get('/occupancy', 'App\Http\Controllers\Admin\OccupancyController@occupancy');
Route::get('/dashorder', 'App\Http\Controllers\Admin\DashOrderController@dashorder');
Route::get('/revenue', 'App\Http\Controllers\Admin\RevenueController@revenue');
Route::get('/staff', 'App\Http\Controllers\Admin\StaffController@staff');
Route::get('/tablereservation', 'App\Http\Controllers\Admin\TableReservationController@tablereservation');
Route::post('/csv-reservation', 'App\Http\Controllers\Admin\TableReservationController@reservationCsv');
Route::get('/restaurants', 'App\Http\Controllers\Admin\RestaurantController@index');



/*================================================================================
                            BACKEND INSERT FUNCTION ROUTING
=================================================================================*/

Route::post('/doaddmenu', 'App\Http\Controllers\Admin\DashMenuController@addfood')->name('doaddmenu.submit');

Route::post('/doaddcategory', 'App\Http\Controllers\Admin\DashMenuController@addcategory')->name('doaddcategory.submit');

Route::post('/doaddadmin', 'App\Http\Controllers\Admin\NewAdminController@doaddadmin')->name('doaddadmin.submit');

Route::post('/doaddstaff', 'App\Http\Controllers\Admin\StaffController@doaddstaff')->name('doaddstaff.submit');

Route::post('/doaddrestaurant', 'App\Http\Controllers\Admin\RestaurantController@doaddrestaurant')->name('doaddrestaurant.submit');

Route::post('/doaddexpense', 'App\Http\Controllers\Admin\ExpenseController@doaddexpense')->name('doaddexpense.submit');

Route::post('/doaddexpensecategories', 'App\Http\Controllers\Admin\ExpenseController@doaddexpensecategories')->name('doaddexpensecategories.submit');


Route::post('/editmenu', 'App\Http\Controllers\Admin\DashMenuController@editmenu')->name('editmenu.submit');

Route::get('/removemenu/{id}', 'App\Http\Controllers\Admin\DashMenuController@removemenu');

Route::get('/confirm/{id}/{name}', 'App\Http\Controllers\Admin\DashOrderController@confirm');

Route::get('/removeorder/{id}', 'App\Http\Controllers\Admin\DashOrderController@removeorder');


// Route::get('/approve/{id}/{name}', 'App\Http\Controllers\Admin\TableReservationController@approve');
Route::post('/approve', 'App\Http\Controllers\Admin\TableReservationController@approve');

Route::get('/deletereservation/{id}', 'App\Http\Controllers\Admin\TableReservationController@deletereservation');

Route::get('/removeexpense/{id}', 'App\Http\Controllers\Admin\ExpenseController@removeexpense');


Route::get('/removestaff/{id}', 'App\Http\Controllers\Admin\StaffController@removestaff');

Route::get('/removerestaurant/{id}', 'App\Http\Controllers\Admin\RestaurantController@removerestaurant');

Route::get('/removemessage/{id}', 'App\Http\Controllers\Admin\MessageController@removemessage');

Route::post('/updateprofile', 'App\Http\Controllers\Admin\DashbaordController@editprofile')->name('updateprofile.submit');

Route::post('/updatestaffprofile', 'App\Http\Controllers\Staff\DashboardController@editprofile')->name('updatestaffprofile.submit');

Route::post('/editstaff', 'App\Http\Controllers\Admin\StaffController@editstaff')->name('editstaff.submit');

Route::post('/editrestaurant', 'App\Http\Controllers\Admin\RestaurantController@editrestaurant')->name('editrestaurant.submit');

Route::post('/editexpense', 'App\Http\Controllers\Admin\ExpenseController@editexpense')->name('editexpense.submit');


Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\Admin\DashbaordController::class, 'dashboard'])->name('dashboard');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\Admin\DashbaordController::class, 'dashboard'])->name('dashboard');


// Route::group(['prefix' => 'staff'], function () {
    Route::get('staff/login', [LoginController::class, 'login']);
    Route::post('staff/login', [ 'as' => 'staff/login', 'uses' => 'App\Http\Controllers\Staff\LoginController@doLogin']);
    Route::get('staff/dashboard', [DashboardController::class, 'dashboard']);
    Route::post('staff/doaddstaff', 'App\Http\Controllers\Staff\DashboardController@doaddstaff')->name('staff.doaddstaff.submit');
    Route::get('staff/removestaff/{id}', 'App\Http\Controllers\Staff\DashboardController@removestaff');
    Route::post('staff/editstaff', 'App\Http\Controllers\Staff\DashboardController@editstaff')->name('staff.editstaff.submit');
    Route::get('staff/tablereservation', 'App\Http\Controllers\Staff\TableReservationController@tablereservation');
    // Route::get('staff/approve/{id}/{name}', 'App\Http\Controllers\Staff\TableReservationController@approve');
    Route::post('staff/approve/', 'App\Http\Controllers\Staff\TableReservationController@approve');
    Route::post('/staff/csv-reservation', 'App\Http\Controllers\Staff\TableReservationController@reservationCsv');

    Route::get('staff/deletereservation/{id}', 'App\Http\Controllers\Staff\TableReservationController@deletereservation');
// });
