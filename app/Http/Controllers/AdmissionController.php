<?php

namespace App\Http\Controllers;

use App\Models\AdmissionInquiry;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()->where('is_active', true)->with('department')
            ->orderBy('level')->orderBy('name')->get();

        return view('pages.admissions', compact('programs'));
    }

    public function storeInquiry(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'program_id' => ['nullable', 'exists:programs,id'],
            'message' => ['nullable', 'string', 'max:2000'],
            'website' => ['prohibited'],
        ], [], ['website' => 'spam field']);

        unset($data['website']);
        if (! empty($data['program_id'])) {
            $data['program_label'] = optional(Program::find($data['program_id']))->name;
        }

        $inquiry = AdmissionInquiry::create($data);

        $to = SiteSetting::get('contact', 'email', config('mail.from.address'));
        if ($to) {
            Mail::raw(
                "New admission inquiry from {$inquiry->name} <{$inquiry->email}>\nProgram: {$inquiry->program_label}\n\n{$inquiry->message}",
                fn ($m) => $m->to($to)->replyTo($inquiry->email, $inquiry->name)->subject('New admission inquiry — NPIUB')
            );
        }

        return back()->with('status', 'Thank you — your inquiry has been received. Our admissions team will contact you shortly.');
    }
}
