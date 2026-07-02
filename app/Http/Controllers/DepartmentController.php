<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Person;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function show(Department $department): View
    {
        abort_unless($department->is_active, 404);

        return view('pages.department', [
            'department' => $department,
            'faculty' => Person::query()
                ->where('type', Person::TYPE_FACULTY)
                ->where('department_id', $department->id)
                ->orderBy('priority')
                ->get(),
            'programs' => $department->programs()->where('is_active', true)->orderBy('priority')->get(),
        ]);
    }
}
