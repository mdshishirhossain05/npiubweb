<footer class="relative mt-24 overflow-hidden bg-ink-700 text-slate-300">
    {{-- gold top rule --}}
    <div class="h-1 w-full bg-gradient-to-r from-primary-600 via-gold-500 to-secondary-600"></div>
    {{-- decorative crest watermark --}}
    <x-brand.motif class="pointer-events-none absolute -right-10 top-10 h-72 w-72 text-white/5" />

    <div class="relative mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:grid-cols-2 lg:grid-cols-4">
        <div class="lg:pr-6">
            <div class="flex items-center gap-3">
                <span class="rounded-lg bg-white p-1.5"><x-brand.logo class="h-11 w-auto" /></span>
                <span class="font-display text-lg font-semibold leading-tight text-white">NPI University<br>of Bangladesh</span>
            </div>
            <p class="mt-5 text-sm leading-relaxed text-slate-400">
                A modern institution committed to quality education, research, and producing skilled, ethical graduates for Bangladesh.
            </p>
            <div class="mt-5 flex gap-3">
                @foreach (['facebook', 'linkedin', 'youtube'] as $social)
                    <a href="#" aria-label="{{ $social }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-slate-300 transition hover:bg-gold-500 hover:text-ink-800">
                        <span class="text-xs font-bold uppercase">{{ substr($social, 0, 1) }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h3 class="mb-5 font-display text-base font-semibold text-white">Quick Links</h3>
            <ul class="space-y-3 text-sm">
                @foreach ([['About Us', '/about'], ['Admissions', '/admissions'], ['Faculty & Staff', '/faculty'], ['Notices', '/notices'], ['News & Events', '/news']] as $l)
                    <li><a href="{{ url($l[1]) }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-gold-300"><span class="text-gold-500">›</span>{{ $l[0] }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="mb-5 font-display text-base font-semibold text-white">Departments</h3>
            <ul class="space-y-3 text-sm">
                @foreach (\App\Models\Department::where('is_active', true)->orderBy('priority')->take(6)->get() as $dept)
                    <li><a href="{{ url('/departments/'.$dept->slug) }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-gold-300"><span class="text-gold-500">›</span>{{ $dept->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h3 class="mb-5 font-display text-base font-semibold text-white">Get in Touch</h3>
            <ul class="space-y-3 text-sm text-slate-400">
                <li class="flex gap-2"><span class="text-gold-500">◆</span>{{ \App\Models\SiteSetting::get('contact', 'address', 'Dhaka, Bangladesh') }}</li>
                <li class="flex gap-2"><span class="text-gold-500">◆</span>{{ \App\Models\SiteSetting::get('contact', 'phone', '+880 1XXX-XXXXXX') }}</li>
                <li class="flex gap-2"><span class="text-gold-500">◆</span>{{ \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd') }}</li>
            </ul>
        </div>
    </div>

    <div class="relative border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-5 text-xs text-slate-500 sm:flex-row">
            <p>&copy; {{ now()->year }} NPI University of Bangladesh. All rights reserved.</p>
            <div class="flex gap-5">
                <a href="{{ url('/privacy') }}" class="hover:text-gold-300">Privacy Policy</a>
                <a href="{{ url('/terms') }}" class="hover:text-gold-300">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>
