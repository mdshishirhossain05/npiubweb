<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\Department;
use App\Models\Page;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds real, verifiable NPI University of Bangladesh structure — faculties'
 * departments and their programmes, plus core static pages — instead of the
 * lorem-ipsum demo data.
 *
 * Sourced from public records (UGC, Wikipedia). Facts limited to what could be
 * verified; anything uncertain (exact intake numbers, individual faculty
 * names) is left for staff to enter through /admin. Idempotent — keyed on
 * department/page slug, so it can be re-run safely.
 *
 * Run with: php artisan db:seed --class=RealContentSeeder
 */
class RealContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedDepartments();
        $this->seedPages();
    }

    private function seedDepartments(): void
    {
        // [name, short_name, sort, [ [programme, level, duration], ... ]]
        $departments = [
            ['Computer Science & Engineering', 'CSE', 1, [
                ['B.Sc. in Computer Science & Engineering', 'B.Sc.', '4 years'],
                ['B.Sc. in Software Engineering', 'B.Sc.', '4 years'],
            ]],
            ['Electrical & Electronic Engineering', 'EEE', 2, [
                ['B.Sc. in Electrical & Electronic Engineering', 'B.Sc.', '4 years'],
            ]],
            ['Civil Engineering', 'CE', 3, [
                ['B.Sc. in Civil Engineering', 'B.Sc.', '4 years'],
            ]],
            ['Mechanical Engineering', 'ME', 4, [
                ['B.Sc. in Mechanical Engineering', 'B.Sc.', '4 years'],
            ]],
            ['Food Engineering & Technology', 'FET', 5, [
                ['B.Sc. in Food Engineering & Technology', 'B.Sc.', '4 years'],
            ]],
            ['Business Administration', 'BBA', 6, [
                ['Bachelor of Business Administration (BBA)', 'Bachelor', '4 years'],
                ['Master of Business Administration (MBA)', 'Master', '1–2 years'],
                ['BBA in Finance & Banking', 'Bachelor', '4 years'],
                ['BBA in Accounting & Information Systems', 'Bachelor', '4 years'],
                ['BBA in Marketing', 'Bachelor', '4 years'],
            ]],
            ['English', 'ENG', 7, [
                ['Bachelor of Arts in English', 'Bachelor', '4 years'],
            ]],
        ];

        foreach ($departments as [$name, $short, $sort, $programmes]) {
            $department = Department::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'short_name' => $short, 'sort_order' => $sort],
            );

            foreach ($programmes as $order => [$programme, $level, $duration]) {
                Program::query()->updateOrCreate(
                    ['slug' => Str::slug($programme)],
                    [
                        'department_id' => $department->id,
                        'name' => $programme,
                        'level' => $level,
                        'duration' => $duration,
                        'sort_order' => $order,
                    ],
                );
            }
        }
    }

    private function seedPages(): void
    {
        $about = <<<'TEXT'
        NPI University of Bangladesh (NPIUB) is a private university established in 2015 and
        located at Basta, Singair, Manikganj. Approved by the University Grants Commission of
        Bangladesh, the university is committed to quality higher education, research and the
        holistic development of its students.

        Through its Faculties of Engineering, Business, Arts & Social Science, and Health Science
        & Technology, NPIUB offers a range of undergraduate and postgraduate programmes taught by
        dedicated faculty in a supportive learning environment.
        TEXT;

        Page::query()->updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About the University',
                'excerpt' => 'A private university in Manikganj, established in 2015 and approved by the UGC of Bangladesh.',
                'body' => $about,
                'status' => ContentStatus::Published,
                'published_at' => now(),
            ],
        );

        Page::query()->updateOrCreate(
            ['slug' => 'admission'],
            [
                'title' => 'Admission',
                'excerpt' => 'Join NPI University of Bangladesh. Admissions are open across all faculties.',
                'body' => "Admissions to NPI University of Bangladesh are open for undergraduate and postgraduate programmes across all faculties.\n\nFor admission enquiries, please contact the admission office at +880 1703-444111 or email info@npiub.edu.bd.",
                'status' => ContentStatus::Published,
                'published_at' => now(),
            ],
        );
    }
}
