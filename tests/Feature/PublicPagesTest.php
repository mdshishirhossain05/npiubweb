<?php

use App\Models\Department;
use App\Models\Page;
use Database\Seeders\SiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the home page on an empty database', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('NPI University')
        ->assertSee('Programs');
});

it('renders an active department page', function () {
    $department = Department::create([
        'name' => 'Computer Science & Engineering',
        'slug' => 'cse',
        'short_name' => 'CSE',
        'is_active' => true,
    ]);

    $this->get('/departments/'.$department->slug)
        ->assertOk()
        ->assertSee('Computer Science &amp; Engineering', false)
        ->assertSee('Programs Offered');
});

it('renders every public index page on an empty database', function (string $path) {
    $this->get($path)->assertOk();
})->with([
    '/faculty', '/notices', '/news', '/events', '/research',
    '/alumni', '/galleries', '/downloads', '/contact', '/admissions', '/search',
]);

it('renders a published static page and 404s an unpublished one', function () {
    $this->seed(SiteSeeder::class);
    $this->get('/about')->assertOk()->assertSee('About');

    Page::where('slug', 'about')->update(['is_published' => false]);
    $this->get('/about')->assertNotFound();
});

it('404s for an inactive department', function () {
    Department::create([
        'name' => 'Hidden',
        'slug' => 'hidden',
        'is_active' => false,
    ]);

    $this->get('/departments/hidden')->assertNotFound();
});
