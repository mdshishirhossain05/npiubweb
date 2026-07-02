@php
    $year = now()->year;
@endphp

<footer class="mt-20 bg-slate-900 text-slate-300">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <div class="flex items-center gap-3">
                <span class="rounded-lg bg-white p-1.5"><x-brand.logo class="h-10 w-auto" /></span>
                <span class="font-bold text-white">NPI University<br>of Bangladesh</span>
            </div>
            <p class="mt-4 text-sm leading-relaxed text-slate-400">
                A modern institution committed to quality education, research, and skilled graduates for Bangladesh.
            </p>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ url('/about') }}" class="hover:text-white">About Us</a></li>
                <li><a href="{{ url('/admissions') }}" class="hover:text-white">Admissions</a></li>
                <li><a href="{{ url('/faculty') }}" class="hover:text-white">Faculty &amp; Staff</a></li>
                <li><a href="{{ url('/notices') }}" class="hover:text-white">Notices</a></li>
                <li><a href="{{ url('/news') }}" class="hover:text-white">News &amp; Events</a></li>
            </ul>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Departments</h3>
            <ul class="space-y-2 text-sm">
                @foreach (\App\Models\Department::where('is_active', true)->orderBy('priority')->take(6)->get() as $dept)
                    <li><a href="{{ url('/departments/'.$dept->slug) }}" class="hover:text-white">{{ $dept->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-white">Contact</h3>
            <ul class="space-y-2 text-sm text-slate-400">
                <li>{{ \App\Models\SiteSetting::get('contact', 'address', 'Dhaka, Bangladesh') }}</li>
                <li>📞 {{ \App\Models\SiteSetting::get('contact', 'phone', '+880') }}</li>
                <li>✉️ {{ \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd') }}</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-slate-800">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-4 text-xs text-slate-400 sm:flex-row">
            <p>&copy; {{ $year }} NPI University of Bangladesh. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="{{ url('/privacy') }}" class="hover:text-white">Privacy</a>
                <a href="{{ url('/terms') }}" class="hover:text-white">Terms</a>
            </div>
        </div>
    </div>
</footer>
