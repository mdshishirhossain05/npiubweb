<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(Request $request): View
    {
        $departments = Department::query()->where('is_active', true)->orderBy('priority')->get();

        $faculty = Person::query()
            ->where('type', Person::TYPE_FACULTY)
            ->where('is_active', true)
            ->when($request->filled('department'), function ($q) use ($request) {
                $q->whereHas('department', fn ($d) => $d->where('slug', $request->string('department')));
            })
            ->orderBy('priority')->orderBy('name')
            ->paginate(12)->withQueryString();

        return view('pages.faculty.index', compact('faculty', 'departments'));
    }

    public function show(Person $person): View
    {
        abort_unless($person->is_active, 404);

        return view('pages.faculty.show', compact('person'));
    }
}
