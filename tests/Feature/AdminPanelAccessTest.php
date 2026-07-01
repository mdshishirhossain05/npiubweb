<?php

use App\Filament\Resources\Departments\DepartmentResource;
use App\Filament\Resources\Downloads\DownloadResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\GalleryAlbums\GalleryAlbumResource;
use App\Filament\Resources\News\NewsResource;
use App\Filament\Resources\Notices\NoticeResource;
use App\Filament\Resources\People\PersonResource;
use App\Filament\Resources\Sliders\SliderResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

function makeUser(string $role): User
{
    $user = User::create([
        'name' => ucfirst($role),
        'email' => $role.'@npiub.edu.bd',
        'password' => Hash::make('secret'),
        'is_active' => true,
    ]);
    $user->assignRole($role);

    return $user;
}

it('lets a super admin reach every resource', function () {
    $user = makeUser('super_admin');

    $this->actingAs($user)->get(PersonResource::getUrl('index'))->assertOk();
    $this->actingAs($user)->get(UserResource::getUrl('index'))->assertOk();
    $this->actingAs($user)->get(SliderResource::getUrl('index'))->assertOk();
});

it('lets an editor manage content but not users', function () {
    $user = makeUser('editor');

    $this->actingAs($user)->get(PersonResource::getUrl('index'))->assertOk();
    // editors have manage_settings, so sliders are allowed
    $this->actingAs($user)->get(SliderResource::getUrl('index'))->assertOk();
    // but not user administration
    $this->actingAs($user)->get(UserResource::getUrl('index'))->assertForbidden();
});

it('blocks a department admin from users and settings', function () {
    $user = makeUser('department_admin');

    $this->actingAs($user)->get(PersonResource::getUrl('index'))->assertOk();
    $this->actingAs($user)->get(UserResource::getUrl('index'))->assertForbidden();
    $this->actingAs($user)->get(SliderResource::getUrl('index'))->assertForbidden();
});

it('renders the media & rich-text create pages without error', function () {
    $user = makeUser('super_admin');

    $pages = [
        PersonResource::getUrl('create'),
        NewsResource::getUrl('create'),
        NoticeResource::getUrl('create'),
        EventResource::getUrl('create'),
        SliderResource::getUrl('create'),
        GalleryAlbumResource::getUrl('create'),
        DepartmentResource::getUrl('create'),
        DownloadResource::getUrl('create'),
    ];

    foreach ($pages as $url) {
        $this->actingAs($user)->get($url)->assertOk();
    }
});

it('keeps users without a role out of the panel entirely', function () {
    $user = User::create([
        'name' => 'No Role',
        'email' => 'norole@npiub.edu.bd',
        'password' => Hash::make('secret'),
        'is_active' => true,
    ]);

    expect($user->canAccessPanel(filament()->getPanel('admin')))->toBeFalse();
});
