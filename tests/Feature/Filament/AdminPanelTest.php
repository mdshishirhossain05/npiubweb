<?php

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Departments\DepartmentResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\FacultyMembers\FacultyMemberResource;
use App\Filament\Resources\Notices\NoticeResource;
use App\Filament\Resources\Pages\PageResource;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Programs\ProgramResource;
use App\Filament\Resources\Slides\SlideResource;
use App\Models\User;
use Filament\Facades\Filament;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
});

it('shows the admin login page to guests', function () {
    get('/admin/login')->assertSuccessful();
});

it('redirects guests away from the dashboard', function () {
    get('/admin')->assertRedirect('/admin/login');
});

it('lets an authenticated user open the dashboard', function () {
    actingAs(User::factory()->create())
        ->get('/admin')
        ->assertSuccessful();
});

it('renders the list and create screen of every content resource', function () {
    $user = User::factory()->create();

    $resources = [
        PageResource::class,
        PostResource::class,
        CategoryResource::class,
        NoticeResource::class,
        EventResource::class,
        SlideResource::class,
        DepartmentResource::class,
        ProgramResource::class,
        FacultyMemberResource::class,
    ];

    foreach ($resources as $resource) {
        actingAs($user)->get($resource::getUrl('index'))->assertSuccessful();
        actingAs($user)->get($resource::getUrl('create'))->assertSuccessful();
    }
});
