<footer class="mt-16 border-t border-slate-200 bg-blue-900 text-slate-200">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">
        <div>
            <div class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-lg bg-white font-bold text-blue-900">NP</span>
                <span class="text-lg font-bold text-white">NPI University of Bangladesh</span>
            </div>
            <p class="mt-4 text-sm leading-relaxed text-slate-300">
                Building futures through quality education, research and community engagement.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-amber-400">Explore</h3>
            <ul class="mt-4 space-y-2 text-sm">
                <li><a href="{{ route('posts.index') }}" class="text-slate-300 hover:text-white">News &amp; Articles</a></li>
                <li><a href="{{ route('notices.index') }}" class="text-slate-300 hover:text-white">Notices</a></li>
                <li><a href="{{ route('events.index') }}" class="text-slate-300 hover:text-white">Events</a></li>
                <li><a href="{{ route('departments.index') }}" class="text-slate-300 hover:text-white">Departments</a></li>
                <li><a href="{{ route('faculty.index') }}" class="text-slate-300 hover:text-white">Faculty</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-amber-400">Contact</h3>
            <ul class="mt-4 space-y-2 text-sm text-slate-300">
                <li>NPI University of Bangladesh</li>
                <li>Manikganj, Bangladesh</li>
                <li><a href="https://npiub.edu.bd" class="hover:text-white">npiub.edu.bd</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-4 text-center text-xs text-slate-400 sm:px-6 lg:px-8">
            &copy; {{ now()->year }} NPI University of Bangladesh. All rights reserved.
        </div>
    </div>
</footer>
