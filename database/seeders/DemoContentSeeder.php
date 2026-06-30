<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use App\Models\Event;
use App\Models\FacultyMember;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Post;
use App\Models\Program;
use App\Models\Slide;
use Illuminate\Database\Seeder;
use Throwable;

/**
 * Fills the site with believable sample content — including images pulled from
 * a placeholder service — so the public pages and admin panel can be
 * demonstrated end to end.
 *
 * NOT run by the default DatabaseSeeder — invoke explicitly with
 * `php artisan db:seed --class=DemoContentSeeder` on a development database.
 * It is purely additive (factories), so never point it at production data.
 * Image downloads need outbound network; failures are tolerated so the seeder
 * still succeeds offline (content is created, just without pictures).
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        Slide::factory()->count(3)->create()->each(function (Slide $slide, int $i): void {
            $this->attachImage($slide, 'image', "https://picsum.photos/seed/npiub-slide-{$i}/1920/1080");
        });

        Page::factory()->create(['title' => 'About NPIUB', 'slug' => 'about']);
        Page::factory()->create(['title' => 'Admission', 'slug' => 'admission']);

        $categories = Category::factory()->count(3)->create();

        Post::factory()
            ->count(9)
            ->recycle($categories)
            ->create()
            ->each(function (Post $post): void {
                $this->attachImage($post, 'featured', "https://picsum.photos/seed/npiub-post-{$post->id}/800/500");
            });

        Notice::factory()->count(8)->create();
        Notice::factory()->count(2)->create(['is_pinned' => true]);

        Event::factory()->count(6)->create();

        Department::factory()
            ->count(4)
            ->has(Program::factory()->count(3))
            ->has(FacultyMember::factory()->count(5))
            ->create();

        FacultyMember::query()->get()->each(function (FacultyMember $member): void {
            $this->attachImage($member, 'photo', "https://i.pravatar.cc/600?img={$member->id}");
        });
    }

    /**
     * Best-effort: download an image into a media collection, ignoring network
     * failures so the seeder remains usable offline.
     */
    private function attachImage(Slide|Post|FacultyMember $model, string $collection, string $url): void
    {
        try {
            $model->addMediaFromUrl($url)->toMediaCollection($collection);
        } catch (Throwable) {
            // No network / image service unavailable — leave the model imageless.
        }
    }
}
