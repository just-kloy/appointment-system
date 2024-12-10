<?php

use App\Http\Controllers\Admin\CalendarEventCrudController;
use Illuminate\Support\Facades\Route;


Route::get('/admin/calendar-events-json', [CalendarEventCrudController::class, 'fetchEvents']);
Route::get('/', function () {
    return redirect()->route('backpack.dashboard');
});
