<?php

use App\Enums\ContentStatus;
use App\Models\Category;
use App\Models\Department;
use App\Models\FacultyMember;
use App\Models\Page;
use App\Models\Post;
use App\Models\Program;

it('auto-generates a slug from the title on create', function () {
    $page = Page::factory()->create(['title' => 'About NPI University', 'slug' => null]);

    expect($page->slug)->toBe('about-npi-university');
});

it('keeps slugs unique within a table', function () {
    $first = Page::factory()->create(['title' => 'Admission Notice', 'slug' => null]);
    $second = Page::factory()->create(['title' => 'Admission Notice', 'slug' => null]);

    expect($first->slug)->toBe('admission-notice')
        ->and($second->slug)->toBe('admission-notice-2');
});

it('does not regenerate the slug on update', function () {
    $page = Page::factory()->create(['title' => 'Original Title', 'slug' => null]);

    $page->update(['title' => 'A Completely New Title']);

    expect($page->fresh()->slug)->toBe('original-title');
});

it('respects an explicitly provided slug', function () {
    $page = Page::factory()->create(['title' => 'Anything', 'slug' => 'custom-slug']);

    expect($page->slug)->toBe('custom-slug');
});

it('casts status to the ContentStatus enum', function () {
    $post = Post::factory()->create(['status' => ContentStatus::Draft]);

    expect($post->fresh()->status)->toBe(ContentStatus::Draft);
});

it('soft deletes pages and posts', function () {
    $page = Page::factory()->create();

    $page->delete();

    expect(Page::count())->toBe(0)
        ->and(Page::withTrashed()->count())->toBe(1);
});

it('relates posts to a category', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->inCategory($category)->create();

    expect($post->category)->not->toBeNull()
        ->and($post->category->is($category))->toBeTrue()
        ->and($category->posts)->toHaveCount(1);
});

it('relates programs and faculty to a department', function () {
    $department = Department::factory()->create();
    Program::factory()->for($department)->create();
    FacultyMember::factory()->for($department)->create();

    expect($department->programs)->toHaveCount(1)
        ->and($department->facultyMembers)->toHaveCount(1);
});
