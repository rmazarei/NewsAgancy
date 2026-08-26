<?php

use App\Http\Controllers\Admin\CityController;
use Illuminate\Support\Facades\Route;

Route::resource('cities', CityController::class);
