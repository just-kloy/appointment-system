<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('backpack.dashboard'); // Redirect to the Backpack dashboard
});
