<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

/**
 * Seeds baseline, editable site content: contact settings and the standard
 * static pages. Safe for production — these are real records staff edit in
 * the admin panel (created only if missing).
 */
class SiteSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['general', 'site_name', 'NPI University of Bangladesh', 'string'],
            ['contact', 'address', 'Rajshahi, Bangladesh', 'string'],
            ['contact', 'phone', '+880 1XXX-XXXXXX', 'string'],
            ['contact', 'email', 'info@npiub.edu.bd', 'string'],
        ] as [$group, $key, $value, $type]) {
            SiteSetting::firstOrCreate(['group' => $group, 'key' => $key], ['value' => $value, 'type' => $type]);
        }

        $pages = [
            'about' => ['About NPIUB', '<p>NPI University of Bangladesh is a modern institution dedicated to quality higher education, research, and skilled graduates. Edit this page from the admin panel.</p>'],
            'vision-mission' => ['Vision & Mission', '<h2>Our Vision</h2><p>To be a leading centre of learning and innovation.</p><h2>Our Mission</h2><p>To deliver quality education and produce ethical, skilled graduates.</p>'],
            'board-of-trustees' => ['Board of Trustees', '<p>The members of the Board of Trustees will be listed here.</p>'],
            'syndicate' => ['Syndicate', '<p>Syndicate members and information will be listed here.</p>'],
            'academic-council' => ['Academic Council', '<p>Academic Council members and information will be listed here.</p>'],
            'faqs' => ['Frequently Asked Questions', '<p>Common questions and answers will appear here.</p>'],
            'privacy' => ['Privacy Policy', '<p>Our privacy policy will be published here.</p>'],
            'terms' => ['Terms of Use', '<p>Our terms of use will be published here.</p>'],
        ];

        foreach ($pages as $slug => [$title, $content]) {
            Page::firstOrCreate(['slug' => $slug], [
                'title' => $title,
                'content' => $content,
                'is_published' => true,
            ]);
        }
    }
}
