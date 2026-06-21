<?php

use App\Http\Controllers\Api\TaxTotalByCustomerController;
use App\Http\Controllers\Api\ArchiveController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(TaxTotalByCustomerController::class)->group(function () {
    Route::get('owner/get-tax-totals/{id}',        'getTaxTotalsByCustomer')->name('building-owners.getTaxTotalsByCustomer');
    Route::get('owner/get-tax-details/{customer}/{tax}',        'getTaxesByCustomerNo')->name('building-owners.getTaxesByCustomerNo');
});
Route::controller(ArchiveController::class)->group(function () {
    Route::get('archives/get-File-Data/{file_number}',        'getFileData')->name('archives.getFileData');

});
