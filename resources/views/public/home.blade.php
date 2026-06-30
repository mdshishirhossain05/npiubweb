<x-public-layout :description="'Official website of NPI University of Bangladesh — programmes, departments, news, notices and events.'">

    {{-- Hero / slide carousel --}}
    @if ($slides->isNotEmpty())
        <section
            x-data="{
                active: 0,
                count: {{ $slides->count() }},
                next() { this.active = (this.active + 1) % this.count },
                prev() { this.active = (this.active - 1 + this.count) % this.count },
            }"
            x-init="setInterval(() => next(), 6000)"
            class="relative overflow-hidden bg-blue-950"
        >
            @foreach ($slides as $index => $slide)
                <div x-show="active === {{ $index }}"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="mx-auto flex max-w-7xl flex-col justify-center px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
                    @if ($slide->subtitle)
                        <p class="text-sm font-semibold uppercase tracking-wider text-amber-400">{{ $slide->subtitle }}</p>
                    @endif
                    <h2 class="mt-2 max-w-3xl text-3xl font-bold tracking-tight text-white sm:text-5xl">
                        {{ $slide->title }}
                    </h2>
                    @if ($slide->link_url)
                        <div class="mt-6">
                            <a href="{{ $slide->link_url }}"
                               class="inline-flex items-center rounded-md bg-amber-500 px-5 py-3 text-sm font-semibold text-blue-950 transition hover:bg-amber-400">
                                Learn more
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach

            @if ($slides->count() > 1)
                <div class="absolute inset-x-0 bottom-5 flex justify-center gap-2">
                    @foreach ($slides as $index => $slide)
                        <button @click="active = {{ $index }}"
                                :class="active === {{ $index }} ? 'bg-amber-400 w-6' : 'bg-white/40 w-2.5'"
                                class="h-2.5 rounded-full transition-all"
                                aria-label="Go to slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </section>
    @else
        <section class="bg-blue-950">
            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-28 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-amber-400">Welcome to</p>
                <h2 class="mt-2 max-w-3xl text-3xl font-bold tracking-tight text-white sm:text-5xl">
                    NPI University of Bangladesh
                </h2>
                <p class="mt-4 max-w-2xl text-lg text-blue-100">
                    Quality education, research and a community built for the future.
                </p>
            </div>
        </section>
    @endif

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        {{-- Latest news + notices --}}
        <div class="grid gap-12 lg:grid-cols-3">
            <section class="lg:col-span-2">
                <div class="flex items-end justify-between">
                    <h2 class="text-2xl font-bold text-slate-900">Latest News</h2>
                    <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">View all &rarr;</a>
                </div>

                @if ($posts->isEmpty())
                    <x-public.empty class="mt-6" message="No news has been published yet." />
                @else
                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach ($posts as $post)
                            <article class="flex flex-col rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                                @if ($post->category)
                                    <span class="text-xs font-semibold uppercase tracking-wide text-amber-600">{{ $post->category->name }}</span>
                                @endif
                                <h3 class="mt-1 font-semibold text-slate-900">
                                    <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-700">{{ $post->title }}</a>
                                </h3>
                                @if ($post->excerpt)
                                    <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $post->excerpt }}</p>
                                @endif
                                <p class="mt-3 text-xs text-slate-400">{{ optional($post->published_at)->format('M j, Y') }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>

            <section>
                <div class="flex items-end justify-between">
                    <h2 class="text-2xl font-bold text-slate-900">Notices</h2>
                    <a href="{{ route('notices.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">All &rarr;</a>
                </div>

                @if ($notices->isEmpty())
                    <x-public.empty class="mt-6" message="No notices yet." />
                @else
                    <ul class="mt-6 divide-y divide-slate-200 rounded-xl border border-slate-200 bg-white">
                        @foreach ($notices as $notice)
                            <li class="flex items-start gap-3 p-4">
                                @if ($notice->is_pinned)
                                    <span class="mt-0.5 rounded bg-amber-100 px-1.5 py-0.5 text-xs font-semibold text-amber-700">Pinned</span>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('notices.show', $notice) }}" class="block truncate text-sm font-medium text-slate-800 hover:text-blue-700">{{ $notice->title }}</a>
                                    <p class="text-xs text-slate-400">{{ optional($notice->notice_date)->format('M j, Y') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>

        {{-- Upcoming events --}}
        @if ($events->isNotEmpty())
            <section class="mt-16">
                <div class="flex items-end justify-between">
                    <h2 class="text-2xl font-bold text-slate-900">Upcoming Events</h2>
                    <a href="{{ route('events.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">View all &rarr;</a>
                </div>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($events as $event)
                        <a href="{{ route('events.show', $event) }}"
                           class="flex flex-col rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                            <span class="text-sm font-bold text-blue-700">{{ optional($event->starts_at)->format('M j') }}</span>
                            <span class="text-xs text-slate-400">{{ optional($event->starts_at)->format('Y · g:i A') }}</span>
                            <h3 class="mt-2 font-semibold text-slate-900">{{ $event->title }}</h3>
                            @if ($event->location)
                                <p class="mt-auto pt-3 text-xs text-slate-500">📍 {{ $event->location }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Departments --}}
        @if ($departments->isNotEmpty())
            <section class="mt-16">
                <div class="flex items-end justify-between">
                    <h2 class="text-2xl font-bold text-slate-900">Departments</h2>
                    <a href="{{ route('departments.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">View all &rarr;</a>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($departments->take(6) as $department)
                        <a href="{{ route('departments.show', $department) }}"
                           class="rounded-xl border border-slate-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-md">
                            <h3 class="font-semibold text-slate-900">{{ $department->name }}</h3>
                            @if ($department->short_name)
                                <p class="text-sm text-slate-500">{{ $department->short_name }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-public-layout>
