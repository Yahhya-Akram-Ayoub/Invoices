<?php

use App\Models\invoices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentController;

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

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/updateDetails', [InvoicesController::class, 'updateDetails']);

Route::resource('/invoices', InvoicesController::class);
Route::resource('/section', SectionController::class);
Route::resource('/product', ProductController::class);
Route::resource('/attachment', InvoicesAttachmentController::class);
Route::resource('/invoices_reports', reportController::class );

Route::post('/delete-attachment', [InvoicesAttachmentController::class, 'delete']);
Route::get('/get_product/{id}', [ProductController::class, 'getProduct']);
Route::get('/showInvoices/{id}', [InvoicesDetailsController::class, 'show']);
Route::get('/edit/{id}', [InvoicesDetailsController::class, 'edit']);
Route::get('/show_pay/{id}', [InvoicesDetailsController::class, 'pay']);
Route::post('/add-attachment', [InvoicesController::class, 'addAttachment']);
Route::post('/restore', [InvoicesController::class, 'restore'])->name('restore');

Route::get('/invoices_paid', [InvoicesController::class, 'invoices_paid']);
Route::get('/invoices_unpaid', [InvoicesController::class, 'invoices_unpaid']);
Route::get('/invoices_partially_paid', [InvoicesController::class, 'invoices_partially_paid']);
Route::get('/archived_invoiced', [InvoicesController::class, 'archived_invoiced']);
Route::post('/destroyWithTrashed', [InvoicesController::class, 'destroyWithTrashed']);
Route::get('/print/{id}', [InvoicesController::class, 'print_invoice']);
Route::get('/markAsRead', [InvoicesController::class , 'markAsRead']);




Route::get('/view_file/{invoice_number}/{attachment_name}', [InvoicesAttachmentController::class, 'show']);
Route::get('/download_file/{invoice_number}/{attachment_name}', [InvoicesAttachmentController::class, 'download']);


Route::get('/export', [InvoicesController::class, 'export']);


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
