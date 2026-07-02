<?php

namespace App\Http\Controllers;

use App\Models\Alumnus;
use Illuminate\View\View;

class AlumniController extends Controller
{
    public function index(): View
    {
        $alumni = Alumnus::query()->where('is_active', true)
            ->orderByDesc('graduation_year')->orderBy('name')->paginate(16);

        return view('pages.alumni.index', compact('alumni'));
    }

    public function show(Alumnus $alumnus): View
    {
        abort_unless($alumnus->is_active, 404);

        return view('pages.alumni.show', ['person' => $alumnus]);
    }
}
