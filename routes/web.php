<?php

use App\Models\invoices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\branchController;
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

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {


Route::get('/home' , [HomeController::class, 'index'])->name('home');
Route::get('/' , [HomeController::class, 'index'])->name('home');


Route::post('/updateDetails', [InvoicesController::class, 'updateDetails']);

Route::resource('/invoices', InvoicesController::class);
Route::resource('/section', SectionController::class);
Route::resource('/branch', branchController::class);
Route::resource('/attachment', InvoicesAttachmentController::class);
Route::resource('/reports', reportController::class );

Route::post('/delete-attachment', [InvoicesAttachmentController::class, 'delete']);
Route::get('/get_branch/{id}', [branchController::class, 'getbranch']);
Route::get('/showInvoices/{id}/{opreation?}', [InvoicesDetailsController::class, 'show']);
Route::get('/edit/{id}', [InvoicesDetailsController::class, 'edit']);
Route::get('/show_pay/{id}', [InvoicesDetailsController::class, 'pay']);
Route::post('/add-attachment', [InvoicesController::class, 'addAttachment']);
//لاستعادة المحذوفات
Route::post('/restore', [InvoicesController::class, 'restore'])->name('restore');
Route::post('/archive', [InvoicesController::class, 'archive'])->name('archive');

Route::get('/invoices_paid', [InvoicesController::class, 'invoices_paid']);
Route::get('/invoices_unpaid', [InvoicesController::class, 'invoices_unpaid']);
Route::get('/invoices_partially_paid', [InvoicesController::class, 'invoices_partially_paid']);
Route::get('/archived_invoiced', [InvoicesController::class, 'archived_invoiced']);
Route::get('/deleted_invoiced', [InvoicesController::class, 'deleted_invoiced']);
Route::post('/destroyWithTrashed', [InvoicesController::class, 'destroyWithTrashed']);
Route::get('/print/{id}', [InvoicesController::class, 'print_invoice']);
Route::get('/markAsRead', [InvoicesController::class , 'markAsRead']);


Route::get('/invoices_report', [reportController::class , 'invoices_report']);
Route::get('/custmers_report', [reportController::class , 'custmers_report']);
Route::post('/search_invoices_report', [reportController::class , 'search_invoices_report']);
Route::post('/search_customers_report', [reportController::class , 'search_customers_report']);




Route::get('/view_file/{invoice_number}/{attachment_name}', [InvoicesAttachmentController::class, 'show']);
Route::get('/download_file/{invoice_number}/{attachment_name}', [InvoicesAttachmentController::class, 'download']);


Route::get('/export', [InvoicesController::class, 'export']);


// Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
// });


});
