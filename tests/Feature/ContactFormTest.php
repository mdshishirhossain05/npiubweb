<?php

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('stores a valid contact message and notifies', function () {
    Mail::fake();

    $this->post('/contact', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'message' => 'I would like more information about admissions.',
    ])->assertRedirect()->assertSessionHas('status');

    expect(ContactMessage::where('email', 'jane@example.com')->exists())->toBeTrue();
});

it('validates required contact fields', function () {
    $this->post('/contact', ['name' => '', 'email' => 'not-an-email', 'message' => ''])
        ->assertSessionHasErrors(['name', 'email', 'message']);

    expect(ContactMessage::count())->toBe(0);
});

it('rejects submissions that fill the honeypot', function () {
    $this->post('/contact', [
        'name' => 'Spam Bot',
        'email' => 'spam@example.com',
        'message' => 'spam',
        'website' => 'http://spam.example',
    ])->assertSessionHasErrors('website');

    expect(ContactMessage::count())->toBe(0);
});
