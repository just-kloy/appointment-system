<?php

use App\Http\Controllers\Admin\CalendarEventCrudController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('employee', 'EmployeeCrudController');
    Route::crud('client', 'ClientCrudController');
    // Route::crud('calendar-event', 'CalendarEventCrudController');

    // Add a custom route for the Calendar view
    Route::get('calendar', [CalendarEventCrudController::class, 'calendar'])->name('calendar.view');
    Route::get('charts/weekly-schedule-chart', 'Charts\WeeklyScheduleChartChartController@response')->name('charts.weekly-schedule-chart.index');
    Route::get('dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('backpack.dashboard');

}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
