<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Event;
use App\Models\News;
use App\Models\Notice;
use App\Models\Person;
use App\Models\Program;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'sliders' => Slider::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'departments' => Department::query()->where('is_active', true)->orderBy('priority')->orderBy('name')->get(),
            'stats' => [
                ['value' => 2015, 'suffix' => '', 'label' => 'Founded', 'count' => false],
                ['value' => (Department::count() ?: 6), 'suffix' => '', 'label' => 'Departments', 'count' => true],
                ['value' => 2000, 'suffix' => '+', 'label' => 'Students', 'count' => true],
                ['value' => (Person::faculty()->count() ?: 50), 'suffix' => '+', 'label' => 'Faculty', 'count' => true],
            ],
            'programs' => Program::query()->where('is_active', true)->with('department')->orderBy('priority')->take(6)->get(),
            'notices' => Notice::query()->where('status', 'published')->orderByDesc('is_important')->orderByDesc('notice_date')->take(6)->get(),
            'news' => News::query()->where('status', 'published')->latest('published_at')->take(3)->get(),
            'events' => Event::query()->where('status', 'published')->where('starts_at', '>=', now()->subDay())->orderBy('starts_at')->take(3)->get(),
            // Real leadership (transcribed from the previous site); photos load
            // from the imported People records by slug when available.
            'leaders' => $this->leaders(),
        ]);
    }

    /**
     * @return array<int, array{name:string, position:string, quote:string, link:?string, photo:?string}>
     */
    private function leaders(): array
    {
        $seed = [
            ['name' => 'Engr. Md. Shamsur Rahman', 'position' => 'Chairman, Board of Trustees', 'slug' => null,
                'link' => '/board-of-trustees',
                'quote' => 'Guiding NPI University with vision, integrity, and a commitment to excellence.'],
            ['name' => 'Prof. Dr. Md. Forhad Hossain', 'position' => 'Vice Chancellor', 'slug' => 'vice-chancellor',
                'link' => '/about',
                'quote' => 'Empowering the next generation through education, innovation, and values.'],
        ];

        $slugs = array_filter(array_column($seed, 'slug'));
        $people = Person::query()->whereIn('slug', $slugs)->get()->keyBy('slug');

        return array_map(function (array $l) use ($people) {
            $person = $l['slug'] ? $people->get($l['slug']) : null;

            return [
                'name' => $l['name'],
                'position' => $l['position'],
                'quote' => $l['quote'],
                'link' => $l['link'],
                'photo' => $person?->getFirstMediaUrl('photo') ?: null,
            ];
        }, $seed);
    }
}
