<?php

use App\Models\AdmissionInquiry;
use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('stores an admission inquiry with the program label', function () {
    Mail::fake();

    $program = Program::create(['name' => 'B.Sc. in CSE', 'slug' => 'bsc-cse', 'level' => 'undergraduate', 'is_active' => true]);

    $this->post('/admissions/inquiry', [
        'name' => 'Applicant One',
        'email' => 'applicant@example.com',
        'phone' => '017',
        'program_id' => $program->id,
        'message' => 'Please send details.',
    ])->assertRedirect()->assertSessionHas('status');

    $inquiry = AdmissionInquiry::first();
    expect($inquiry)->not->toBeNull();
    expect($inquiry->program_label)->toBe('B.Sc. in CSE');
    expect($inquiry->status)->toBe(AdmissionInquiry::STATUS_NEW);
});

it('validates the admission inquiry', function () {
    $this->post('/admissions/inquiry', ['name' => '', 'email' => 'bad'])
        ->assertSessionHasErrors(['name', 'email']);

    expect(AdmissionInquiry::count())->toBe(0);
});
