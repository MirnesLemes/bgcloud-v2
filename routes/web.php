<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {


    //Route::resource('/reports/quotation/{id}','App\Http\Controllers\PDFController')->name('reports.quotation.id');

    Route::get('/reports/stockentry/{id}', [App\Http\Controllers\PrintController::class, 'stockEntry'])->name('reports.stockentry.view');


});
