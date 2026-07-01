<footer class="border-t-4 border-brass-500 bg-navy-950 text-navy-50/70">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 md:grid-cols-4 lg:px-8">
        <div class="md:col-span-2">
            <div class="flex items-center gap-3">
                <span class="grid h-11 w-11 place-items-center rounded-full border-2 border-brass-500 font-display font-bold text-white">NP</span>
                <span class="font-display text-lg font-bold text-white">NPI University of Bangladesh</span>
            </div>
            <p class="mt-4 max-w-md text-sm leading-relaxed">
                A private university established in 2015, committed to quality education,
                research and the personal growth of every student — at Basta, Singair,
                Manikganj.
            </p>
        </div>

        <div>
            <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-white">Explore</h3>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li><a href="{{ route('posts.index') }}" class="hover:text-white">News</a></li>
                <li><a href="{{ route('notices.index') }}" class="hover:text-white">Notices</a></li>
                <li><a href="{{ route('events.index') }}" class="hover:text-white">Events</a></li>
                <li><a href="{{ route('departments.index') }}" class="hover:text-white">Departments</a></li>
                <li><a href="{{ route('faculty.index') }}" class="hover:text-white">Faculty</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-white">Contact</h3>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li>Basta, Singair, Manikganj, Dhaka</li>
                <li><a href="tel:+8801703444111" class="hover:text-white">+880 1703-444111</a></li>
                <li><a href="mailto:info@npiub.edu.bd" class="hover:text-white">info@npiub.edu.bd</a></li>
                <li><a href="https://npiub.edu.bd" class="hover:text-white">npiub.edu.bd</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-5 text-center text-xs text-navy-50/50 lg:px-8">
            &copy; {{ now()->year }} NPI University of Bangladesh. All rights reserved.
        </div>
    </div>
</footer>
