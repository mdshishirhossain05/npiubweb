<?php

use App\Enums\ContentStatus;
use App\Models\Department;
use App\Models\Event;
use App\Models\FacultyMember;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Post;
use App\Models\Program;
use App\Models\Slide;

use function Pest\Laravel\get;

it('renders the home page', function () {
    Slide::factory()->create(['is_active' => true]);
    Post::factory()->create(['status' => ContentStatus::Published, 'published_at' => now()->subDay()]);

    get('/')
        ->assertSuccessful()
        ->assertSee('NPI University');
});

it('lists only published posts and hides drafts', function () {
    $live = Post::factory()->create(['status' => ContentStatus::Published, 'published_at' => now()->subDay()]);
    $draft = Post::factory()->create(['status' => ContentStatus::Draft]);

    get(route('posts.index'))
        ->assertSuccessful()
        ->assertSee($live->title)
        ->assertDontSee($draft->title);
});

it('shows a published post but 404s a draft', function () {
    $live = Post::factory()->create(['status' => ContentStatus::Published, 'published_at' => now()->subDay()]);
    $draft = Post::factory()->create(['status' => ContentStatus::Draft]);

    get(route('posts.show', $live))->assertSuccessful()->assertSee($live->title);
    get(route('posts.show', $draft))->assertNotFound();
});

it('hides posts scheduled for the future', function () {
    $scheduled = Post::factory()->create([
        'status' => ContentStatus::Published,
        'published_at' => now()->addWeek(),
    ]);

    get(route('posts.index'))->assertSuccessful()->assertDontSee($scheduled->title);
    get(route('posts.show', $scheduled))->assertNotFound();
});

it('renders a static page by slug and 404s a draft page', function () {
    $page = Page::factory()->create([
        'title' => 'About Us',
        'slug' => 'about-us',
        'status' => ContentStatus::Published,
        'published_at' => now()->subDay(),
    ]);
    $draft = Page::factory()->create(['slug' => 'secret', 'status' => ContentStatus::Draft]);

    get('/about-us')->assertSuccessful()->assertSee('About Us');
    get('/secret')->assertNotFound();
});

it('does not let the page catch-all shadow the news route', function () {
    // A page whose slug collides with a fixed route segment must never be
    // reachable in a way that breaks that section.
    Post::factory()->create(['status' => ContentStatus::Published, 'published_at' => now()->subDay()]);

    get('/news')->assertSuccessful();
});

it('renders the notices, events, departments and faculty pages', function () {
    Notice::factory()->create(['status' => ContentStatus::Published, 'published_at' => now()->subDay()]);
    Event::factory()->create(['status' => ContentStatus::Published, 'published_at' => now()->subDay(), 'starts_at' => now()->addWeek()]);

    $department = Department::factory()->create();
    Program::factory()->for($department)->create();
    FacultyMember::factory()->for($department)->create();

    get(route('notices.index'))->assertSuccessful();
    get(route('events.index'))->assertSuccessful();
    get(route('departments.index'))->assertSuccessful();
    get(route('departments.show', $department))->assertSuccessful()->assertSee($department->name);
    get(route('faculty.index'))->assertSuccessful();
});
