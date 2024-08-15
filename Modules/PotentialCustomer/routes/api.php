<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\PotentialCustomer\app\Http\Controllers\Dashboard\CountryController;

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

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('potentialcustomer', fn (Request $request) => $request->user())->name('potentialcustomer');
});
Route::get("/dataTable", [CountryController::class,"dataTable"])->name("dataTable");
