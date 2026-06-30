<?php

use App\Models\FacultyMember;
use App\Models\Post;
use App\Models\Slide;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

it('stores and exposes a featured image url for a post', function () {
    $post = Post::factory()->create();

    $post->addMedia(UploadedFile::fake()->image('news.jpg', 1200, 800))
        ->toMediaCollection('featured');

    expect($post->featuredImageUrl())->toBeString()->not->toBeEmpty();
});

it('keeps a single image per slide', function () {
    $slide = Slide::factory()->create();

    $slide->addMedia(UploadedFile::fake()->image('one.jpg'))->toMediaCollection('image');
    $slide->addMedia(UploadedFile::fake()->image('two.jpg'))->toMediaCollection('image');

    expect($slide->getMedia('image'))->toHaveCount(1)
        ->and($slide->imageUrl())->toBeString();
});

it('returns null image urls when nothing has been uploaded', function () {
    expect(Post::factory()->create()->featuredImageUrl())->toBeNull()
        ->and(Slide::factory()->create()->imageUrl())->toBeNull()
        ->and(FacultyMember::factory()->create()->photoUrl())->toBeNull();
});
