<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FacultyMember;
use Illuminate\Contracts\View\View;

class FacultyController extends Controller
{
    public function index(): View
    {
        return view('public.faculty.index', [
            'faculty' => FacultyMember::query()
                ->with('department')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
