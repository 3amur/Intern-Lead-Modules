<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageTextController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DataTableSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/getRole', [UserController::class,'getRole'])->name('users.getRole');

Route::middleware(['auth', 'checkRole'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home.index');
    Route::get('/setting/them-setting', [DashboardController::class, 'themeSetting'])->name('setting.themeSetting');
    Route::get('/setting/module-setting', [DashboardController::class, 'moduleSetting'])->name('setting.moduleSetting');
    Route::get('/setting/general-setting', [DashboardController::class, 'generalSetting'])->name('setting.generalSetting');

    /* Start DataTable Routes */
    Route::post('/dataTableSettings', [DataTableSettingController::class,'store'])->name('dataTableSettings.store');
    /* End DataTable Routes */

    /* Start User Routes */
    Route::post('/users/export',[ UserController::class,'export'])->name('users.export');
    Route::resource('/users', UserController::class);
    /* End User Routes */

    /* Start Roles Routes */
    Route::post('/roles/export',[ RoleController::class,'export'])->name('roles.export');
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/rolesPermissions', [UserController::class, 'rolesPermissions'])->name('roles.rolesPermissions');
    /* End Roles Routes */
});



require __DIR__.'/auth.php';
