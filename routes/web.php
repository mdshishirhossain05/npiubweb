<?php

use App\Http\Controllers\Public\DepartmentController;
use App\Http\Controllers\Public\EventController;
use App\Http\Controllers\Public\FacultyController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NoticeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/news', [PostController::class, 'index'])->name('posts.index');
Route::get('/news/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice:slug}', [NoticeController::class, 'show'])->name('notices.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/{department:slug}', [DepartmentController::class, 'show'])->name('departments.show');

Route::get('/faculty', [FacultyController::class, 'index'])->name('faculty.index');

// Catch-all for static pages by slug. Kept last so it never shadows the
// specific routes above.
Route::get('/{page:slug}', [PageController::class, 'show'])->name('pages.show');
