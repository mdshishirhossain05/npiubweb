<?php

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the home page on an empty database', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('NPI University')
        ->assertSee('Featured Programs');
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

it('404s for an inactive department', function () {
    Department::create([
        'name' => 'Hidden',
        'slug' => 'hidden',
        'is_active' => false,
    ]);

    $this->get('/departments/hidden')->assertNotFound();
});
