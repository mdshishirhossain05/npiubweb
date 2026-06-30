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

/**
 * Fills the site with believable sample content so the public pages and the
 * admin panel can be demonstrated end to end.
 *
 * NOT run by the default DatabaseSeeder — invoke explicitly with
 * `php artisan db:seed --class=DemoContentSeeder` on a development database.
 * It is purely additive (factories), so never point it at production data.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        Slide::factory()->count(3)->create();

        Page::factory()->create(['title' => 'About NPIUB', 'slug' => 'about']);
        Page::factory()->create(['title' => 'Admission', 'slug' => 'admission']);

        $categories = Category::factory()->count(3)->create();

        Post::factory()
            ->count(9)
            ->recycle($categories)
            ->create();

        Notice::factory()->count(8)->create();
        Notice::factory()->count(2)->create(['is_pinned' => true]);

        Event::factory()->count(6)->create();

        Department::factory()
            ->count(4)
            ->has(Program::factory()->count(3))
            ->has(FacultyMember::factory()->count(5))
            ->create();
    }
}
