<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\News;
use App\Models\Notice;
use App\Models\Page;
use App\Models\Person;
use App\Models\Research;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', now()->addHours(6), function () {
            $urls = [];
            $add = function (string $path, $lastmod = null, string $freq = 'weekly', string $priority = '0.6') use (&$urls) {
                $urls[] = [
                    'loc' => url($path),
                    'lastmod' => $lastmod ? Carbon::parse($lastmod)->toAtomString() : null,
                    'freq' => $freq,
                    'priority' => $priority,
                ];
            };

            // Static / index routes
            $add('/', null, 'daily', '1.0');
            foreach (['about', 'admissions', 'faculty', 'notices', 'news', 'events', 'research', 'alumni', 'galleries', 'downloads', 'contact'] as $p) {
                $add('/'.$p, null, 'weekly', '0.7');
            }

            Page::where('is_published', true)->get(['slug', 'updated_at'])->each(fn ($m) => $add('/'.$m->slug, $m->updated_at, 'monthly', '0.5'));
            Department::where('is_active', true)->get(['slug', 'updated_at'])->each(fn ($m) => $add('/departments/'.$m->slug, $m->updated_at, 'monthly', '0.8'));
            Person::where('is_active', true)->get(['slug', 'updated_at'])->each(fn ($m) => $add('/faculties/'.$m->slug, $m->updated_at, 'monthly', '0.5'));
            Notice::where('status', 'published')->get(['slug', 'updated_at'])->each(fn ($m) => $add('/notices/'.$m->slug, $m->updated_at, 'weekly', '0.6'));
            News::where('status', 'published')->get(['slug', 'updated_at'])->each(fn ($m) => $add('/news/'.$m->slug, $m->updated_at, 'weekly', '0.6'));
            Event::where('status', 'published')->get(['slug', 'updated_at'])->each(fn ($m) => $add('/events/'.$m->slug, $m->updated_at, 'weekly', '0.5'));
            Research::where('status', 'published')->get(['slug', 'updated_at'])->each(fn ($m) => $add('/research/'.$m->slug, $m->updated_at, 'monthly', '0.5'));
            GalleryAlbum::where('is_active', true)->get(['slug', 'updated_at'])->each(fn ($m) => $add('/galleries/'.$m->slug, $m->updated_at, 'monthly', '0.4'));

            return view('sitemap', compact('urls'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
