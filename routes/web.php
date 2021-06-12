<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('/invoices', InvoicesController::class);
Route::resource('/section', SectionController::class);
Route::resource('/product',ProductController::class);
Route::resource('/attachment',InvoicesAttachmentController::class);




Route::post('/delete-attachment',[InvoicesAttachmentController::class , 'delete']);
Route::get('/get_product/{id}',[ProductController::class , 'getProduct']);
Route::get('/showInvoices/{id}',[InvoicesDetailsController::class , 'show']);
Route::get('/edit/{id}',[InvoicesDetailsController::class , 'edit']);
Route::post('/add-attachment',[InvoicesController::class , 'addAttachment']);



Route::get('/view_file/{invoice_number}/{attachment_name}',[InvoicesAttachmentController::class , 'show']);
Route::get('/download_file/{invoice_number}/{attachment_name}',[InvoicesAttachmentController::class , 'download']);
