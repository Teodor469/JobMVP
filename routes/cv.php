<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CVFormController;

Route::middleware('auth')->group(function () {
    Route::resource('cv', CVFormController::class);
});