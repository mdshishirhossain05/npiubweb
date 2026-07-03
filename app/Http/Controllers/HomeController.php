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
                ['value' => '2015', 'label' => 'Founded'],
                ['value' => (Department::count() ?: 6), 'label' => 'Departments'],
                ['value' => '2,000+', 'label' => 'Students'],
                ['value' => (Person::faculty()->count() ?: 50).'+', 'label' => 'Faculty Members'],
            ],
            'programs' => Program::query()->where('is_active', true)->with('department')->orderBy('priority')->take(4)->get(),
            'notices' => Notice::query()->where('status', 'published')->orderByDesc('is_important')->orderByDesc('notice_date')->take(5)->get(),
            'news' => News::query()->where('status', 'published')->latest('published_at')->take(3)->get(),
            'events' => Event::query()->where('status', 'published')->where('starts_at', '>=', now()->subDay())->orderBy('starts_at')->take(3)->get(),
            'leadership' => Person::query()->where('type', Person::TYPE_LEADERSHIP)->orderBy('priority')->first(),
        ]);
    }
}
