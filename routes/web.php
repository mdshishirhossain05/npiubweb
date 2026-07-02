<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// 301 redirects preserving legacy URLs that changed.
Route::permanentRedirect('/apply-admission', '/admissions');
Route::permanentRedirect('/undergraduate-program', '/admissions');
Route::permanentRedirect('/graduate-program', '/admissions');
Route::permanentRedirect('/location', '/contact');

// Academics
Route::get('/departments/{department:slug}', [DepartmentController::class, 'show'])->name('departments.show');

// Admissions
Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions');
Route::post('/admissions/inquiry', [AdmissionController::class, 'storeInquiry'])
    ->middleware('throttle:10,1')->name('admissions.inquiry');

// Faculty & people (legacy URLs preserved)
Route::get('/faculty', [FacultyController::class, 'index'])->name('faculty.index');
Route::get('/faculties/{person:slug}', [FacultyController::class, 'show'])->name('faculties.show');
Route::get('/officers/{person:slug}', [FacultyController::class, 'show'])->name('officers.show');
Route::get('/offices/{person:slug}', [FacultyController::class, 'show'])->name('offices.show');

// Notices
Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice:slug}', [NoticeController::class, 'show'])->name('notices.show');

// News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

// Research
Route::get('/research', [ResearchController::class, 'index'])->name('research.index');
Route::get('/research/{research:slug}', [ResearchController::class, 'show'])->name('research.show');

// Alumni
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/{alumnus:slug}', [AlumniController::class, 'show'])->name('alumni.show');

// Gallery (legacy path /galleries)
Route::get('/galleries', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galleries/{album:slug}', [GalleryController::class, 'show'])->name('gallery.show');

// Downloads
Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads.index');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:10,1')->name('contact.store');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Editable static pages (About, Vision/Mission, Board of Trustees, etc.)
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', 'about|vision-mission|board-of-trustees|syndicate|academic-council|faqs|privacy|terms|history|mission-vision')
    ->name('pages.show');
