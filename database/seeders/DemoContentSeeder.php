<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Event;
use App\Models\News;
use App\Models\Notice;
use App\Models\Person;
use App\Models\Program;
use App\Models\Slider;
use App\Support\Legacy\DepartmentResolver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * LOCAL PREVIEW ONLY — sample content for design review/screenshots.
 * NOT referenced by DatabaseSeeder and must never run in production; real
 * content comes from the legacy importer + the admin panel.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        app(DepartmentResolver::class)->seed();

        Department::query()->update(['is_active' => true]);
        $departments = Department::all();

        foreach ($departments as $d) {
            $d->update([
                'summary' => "The Department of {$d->name} offers industry-focused education with modern labs and experienced faculty.",
                'overview' => "<p>The Department of <strong>{$d->name}</strong> is committed to academic excellence, research, and producing job-ready graduates. Our curriculum blends theory with hands-on practice.</p>",
                'established_year' => 2016,
            ]);

            Program::firstOrCreate(
                ['slug' => Str::slug("bsc-{$d->slug}")],
                ['name' => "B.Sc. in {$d->name}", 'department_id' => $d->id, 'level' => 'undergraduate', 'priority' => 1]
            );
        }

        $titles = ['Professor', 'Associate Professor', 'Assistant Professor', 'Lecturer'];
        foreach ($departments as $d) {
            foreach (range(1, 3) as $n) {
                Person::firstOrCreate(
                    ['slug' => Str::slug("{$d->short_name}-faculty-{$n}")],
                    [
                        'name' => "Dr. {$d->short_name} Faculty {$n}",
                        'type' => Person::TYPE_FACULTY,
                        'department_id' => $d->id,
                        'position' => $titles[array_rand($titles)],
                        'biography' => 'Dedicated educator and researcher.',
                        'priority' => $n,
                    ]
                );
            }
        }

        Person::firstOrCreate(
            ['slug' => 'vice-chancellor'],
            [
                'name' => 'Prof. Dr. Vice Chancellor',
                'type' => Person::TYPE_LEADERSHIP,
                'position' => 'Vice Chancellor',
                'office_type' => 'Administration',
                'biography' => 'Welcome to NPI University of Bangladesh. Our mission is to nurture skilled, ethical graduates who contribute to national development through quality education and research.',
                'priority' => 1,
            ]
        );

        foreach (range(1, 6) as $n) {
            Notice::firstOrCreate(
                ['slug' => "demo-notice-{$n}"],
                [
                    'title' => "Notice regarding semester final examination schedule ({$n})",
                    'description' => '<p>Details of the examination schedule are attached.</p>',
                    'category' => ['exam', 'admission', 'general'][$n % 3],
                    'notice_date' => now()->subDays($n * 2),
                    'published_by' => 'Registrar',
                    'is_important' => $n <= 2,
                    'status' => 'published',
                ]
            );
        }

        foreach (range(1, 4) as $n) {
            News::firstOrCreate(
                ['slug' => "demo-news-{$n}"],
                [
                    'title' => "NPIUB celebrates milestone achievement number {$n}",
                    'content' => '<p>Full story goes here.</p>',
                    'excerpt' => 'A short summary of this news article for the card preview.',
                    'author_name' => 'Public Relations',
                    'category' => 'campus',
                    'published_at' => now()->subDays($n * 3),
                    'status' => 'published',
                ]
            );
        }

        foreach (range(1, 3) as $n) {
            Event::firstOrCreate(
                ['slug' => "demo-event-{$n}"],
                [
                    'title' => "Annual Tech Fest {$n}",
                    'description' => '<p>Join us for a day of innovation.</p>',
                    'starts_at' => now()->addDays($n * 5),
                    'venue' => 'Main Campus Auditorium',
                    'status' => 'published',
                ]
            );
        }

        Slider::firstOrCreate(['title' => 'Welcome to NPIUB'], [
            'subtitle' => 'Building skilled graduates for Bangladesh',
            'cta_label' => 'Apply Now',
            'cta_url' => '/admissions',
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
