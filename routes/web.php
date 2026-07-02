<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/departments/{department:slug}', [DepartmentController::class, 'show'])
    ->name('departments.show');

/*
 * Public pages below are wired up in Phase 5 (About, Admissions, Faculty,
 * Notices, News, Events, Gallery, Downloads, Contact, search). Navigation
 * links already point at these paths.
 */
