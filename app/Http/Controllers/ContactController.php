<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            // Honeypot: real users leave this empty.
            'website' => ['prohibited'],
        ], [], ['website' => 'spam field']);

        unset($data['website']);
        $message = ContactMessage::create($data);

        $to = SiteSetting::get('contact', 'email', config('mail.from.address'));
        if ($to) {
            Mail::raw(
                "New contact message from {$message->name} <{$message->email}>\n\n{$message->message}",
                fn ($m) => $m->to($to)->replyTo($message->email, $message->name)->subject('New contact message — NPIUB')
            );
        }

        return back()->with('status', 'Thank you — your message has been sent. We will get back to you soon.');
    }
}
