<footer class="bg-ink-900 text-slate-400">
    <div class="mx-auto max-w-7xl px-4 lg:px-6">
        {{-- Big wordmark row --}}
        <div class="flex flex-col justify-between gap-8 border-b border-white/10 py-14 md:flex-row md:items-end">
            <div class="max-w-md">
                <div class="flex items-center gap-3">
                    <span class="bg-white p-1.5"><x-brand.logo class="h-10 w-auto" /></span>
                    <span class="font-display text-lg font-semibold leading-tight text-white">NPI University<br>of Bangladesh</span>
                </div>
                <p class="mt-5 text-sm leading-relaxed text-slate-400">
                    A modern institution committed to quality education, research, and producing skilled, ethical graduates for Bangladesh.
                </p>
            </div>
            <x-ui.button href="{{ url('/admissions') }}" variant="white" size="lg">Apply for Admission</x-ui.button>
        </div>

        {{-- Columns --}}
        <div class="grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Explore</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach ([['About', '/about'], ['Admissions', '/admissions'], ['Faculty & Staff', '/faculty'], ['Notices', '/notices'], ['News & Events', '/news']] as $l)
                        <li><a href="{{ url($l[1]) }}" class="text-slate-400 transition hover:text-white">{{ $l[0] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Departments</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach (\App\Models\Department::where('is_active', true)->orderBy('priority')->take(6)->get() as $dept)
                        <li><a href="{{ url('/departments/'.$dept->slug) }}" class="text-slate-400 transition hover:text-white">{{ $dept->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-400">
                    <li>{{ \App\Models\SiteSetting::get('contact', 'address', 'Dhaka, Bangladesh') }}</li>
                    <li><a href="tel:" class="transition hover:text-white">{{ \App\Models\SiteSetting::get('contact', 'phone', '+880 1XXX-XXXXXX') }}</a></li>
                    <li><a href="mailto:{{ \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd') }}" class="transition hover:text-white">{{ \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd') }}</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Follow</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach (['Facebook', 'LinkedIn', 'YouTube'] as $s)
                        <li><a href="#" class="text-slate-400 transition hover:text-white">{{ $s }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-2 border-t border-white/10 py-6 text-xs text-slate-500 sm:flex-row">
            <p>&copy; {{ now()->year }} NPI University of Bangladesh. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="{{ url('/privacy') }}" class="transition hover:text-white">Privacy</a>
                <a href="{{ url('/terms') }}" class="transition hover:text-white">Terms</a>
            </div>
        </div>
    </div>
</footer>
