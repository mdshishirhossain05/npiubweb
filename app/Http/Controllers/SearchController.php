<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Notice;
use App\Models\Person;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->string('q'));
        $results = collect();

        if ($q !== '') {
            $like = '%'.$q.'%';

            $notices = Notice::where('status', 'published')->where('title', 'like', $like)->limit(10)->get()
                ->map(fn ($n) => ['type' => 'Notice', 'title' => $n->title, 'url' => url('/notices/'.$n->slug), 'date' => $n->notice_date]);

            $news = News::where('status', 'published')->where('title', 'like', $like)->limit(10)->get()
                ->map(fn ($n) => ['type' => 'News', 'title' => $n->title, 'url' => url('/news/'.$n->slug), 'date' => $n->published_at]);

            $people = Person::where('is_active', true)->where('name', 'like', $like)->limit(10)->get()
                ->map(fn ($p) => ['type' => 'Faculty', 'title' => $p->name.' — '.$p->position, 'url' => url('/faculties/'.$p->slug), 'date' => null]);

            $programs = Program::where('is_active', true)->where('name', 'like', $like)->limit(10)->get()
                ->map(fn ($p) => ['type' => 'Program', 'title' => $p->name, 'url' => url('/departments/'.optional($p->department)->slug), 'date' => null]);

            $results = $notices->concat($news)->concat($people)->concat($programs);
        }

        return view('pages.search', ['q' => $q, 'results' => $results]);
    }
}
