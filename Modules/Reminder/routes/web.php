<?php

use Illuminate\Support\Facades\Route;
use Modules\Reminder\app\Http\Controllers\Dashboard\CalendarController;
use Modules\Reminder\app\Http\Controllers\Dashboard\ContactController;
use Modules\Reminder\app\Http\Controllers\Dashboard\ReminderController;

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

Route::post('/contacts/import-v-card',[ContactController::class,'importVCard'])->name('contacts.importVCard');


Route::prefix('reminders')->middleware(['auth', 'remindersRole'])->group( function () {

    Route::get('/home', [ReminderController::class,'home'])->name('reminders.home');
    /* Start Reminder Routes  */
    Route::post('/reminders/export', [ReminderController::class, 'export'])->name('reminders.export');
    Route::resource('/reminders', ReminderController::class);

    Route::get('/reminders_on_calendar', [CalendarController::class,'remindersOnCalendar'])->name('reminders.remindersOnCalendar');
    Route::get('/edit_reminders_on_calendar/{reminder}', [CalendarController::class,'editRemindersOnCalendar'])->name('reminders.editRemindersOnCalendar');
    Route::put('/update_reminders_on_calendar/{reminder}', [CalendarController::class,'updateRemindersOnCalendar'])->name('reminders.updateRemindersOnCalendar');
    Route::put('/update_reminders_date_with_drag_and_drop', [CalendarController::class,'updateDateWithDragAndDrop'])->name('reminders.updateDateWithDragAndDrop');
    Route::get('/calendar',[CalendarController::class,'calendar'])->name('reminders.calendar');

    /* Start Contacts Route */
    Route::post('/contacts/export', [ContactController::class, 'export'])->name('contacts.export');
    Route::resource('/contacts', ContactController::class);

});
