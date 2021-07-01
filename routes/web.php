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

Route::fallback(function () {
    return ['name' => 'yahhay'];
});
Route::group(['middleware' => ['auth']], function () {


    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('home');


    Route::group(['middleware' => ['permission:Invoices']], function () {

        Route::resource('/invoices', InvoicesController::class)->middleware(['permission:Iinvoices list']);
        Route::get('/invoices_paid', [InvoicesController::class, 'invoices_paid'])->middleware(['permission:Paid invoices']);
        Route::get('/invoices_unpaid', [InvoicesController::class, 'invoices_unpaid'])->middleware(['permission:Unpaid invoices']);
        Route::get('/invoices_partially_paid', [InvoicesController::class, 'invoices_partially_paid'])->middleware(['permission:partilly paid invoices']);
        Route::get('/archived_invoiced', [InvoicesController::class, 'archived_invoiced'])->middleware(['permission:Artiched invoices']);
        Route::get('/deleted_invoiced', [InvoicesController::class, 'deleted_invoiced'])->middleware(['permission:Archive invoice']);

        Route::post('/archive', [InvoicesController::class, 'archive'])->name('archive')->middleware(['permission:Archive invoice']);
        Route::get('/edit/{id}', [InvoicesDetailsController::class, 'edit'])->middleware(['permission:Modify invoice']);
        Route::post('/updateDetails', [InvoicesController::class, 'updateDetails'])->middleware(['permission:Change paid status']);
        Route::post('/destroyWithTrashed', [InvoicesController::class, 'destroyWithTrashed'])->middleware(['permission:Deleted invoices']);
        Route::post('/restore', [InvoicesController::class, 'restore'])->name('restore');
        Route::get('/showInvoices/{id}/{opreation?}', [InvoicesDetailsController::class, 'show']);
        Route::get('/show_pay/{id}', [InvoicesDetailsController::class, 'pay']);

        Route::post('/delete-attachment', [InvoicesAttachmentController::class, 'delete'])->middleware(['permission:Delete Attachment']);
        Route::post('/add-attachment', [InvoicesController::class, 'addAttachment'])->middleware(['permission:Add Attachment']);

        Route::get('/print/{id}', [InvoicesController::class, 'print_invoice'])->middleware(['permission:Print invoice']);
        Route::get('/export', [InvoicesController::class, 'export'])->middleware(['permission:Export EXCEL']);

        Route::get('/view_file/{invoice_number}/{attachment_name}', [InvoicesAttachmentController::class, 'show']);
        Route::get('/download_file/{invoice_number}/{attachment_name}', [InvoicesAttachmentController::class, 'download']);

    });


    Route::group(['middleware' => ['permission:Sittings']], function () {

        Route::resource('/section', SectionController::class)->middleware(['permission:Sections']);
        Route::resource('/branch', branchController::class)->middleware(['permission:Branchs']);

    });


    // Reports
    Route::group(['middleware' => ['permission:Report']], function () {

        Route::group(['middleware' => ['permission:Invoices report']], function () {
            Route::resource('/reports', reportController::class);
            Route::get('/invoices_report', [reportController::class, 'invoices_report']);
            Route::get('/search_invoices_report', [reportController::class, 'search_invoices_report']);

        });

        Route::group(['middleware' => ['permission:Customer report']], function () {

            Route::get('/custmers_report', [reportController::class, 'custmers_report']);
            Route::get('/search_customers_report', [reportController::class, 'search_customers_report']);

        });

    });


    //Users and roles sittings
    Route::group(['middleware' => ['permission:Users']], function () {

        Route::resource('roles', RoleController::class)->middleware(['permission:Roles users']);

        Route::resource('users', UserController::class)->middleware(['permission:Users list']);

    });


    Route::get('/get_branch/{id}', [branchController::class, 'getbranch']);

    Route::get('/search/{txt}', [InvoicesController::class, 'search']);

    Route::get('/markAsRead', [InvoicesController::class, 'markAsRead'])->middleware(['permission:Notification']);


});
