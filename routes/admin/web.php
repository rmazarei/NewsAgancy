<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    require __DIR__.'/dashboard.php';
    require __DIR__.'/news.php';
    require __DIR__.'/categories.php';
    require __DIR__.'/cities.php';
});
