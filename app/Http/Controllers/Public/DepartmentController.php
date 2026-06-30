<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Contracts\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        return view('public.departments.index', [
            'departments' => Department::query()
                ->withCount(['programs', 'facultyMembers'])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(Department $department): View
    {
        $department->load([
            'programs' => fn ($query) => $query->orderBy('sort_order')->orderBy('name'),
            'facultyMembers' => fn ($query) => $query->orderBy('sort_order')->orderBy('name'),
        ]);

        return view('public.departments.show', ['department' => $department]);
    }
}
