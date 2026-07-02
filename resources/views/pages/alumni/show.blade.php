<x-layouts.app :title="$person->name.' — '.config('app.name')">
    <div class="mx-auto max-w-4xl px-4 py-12 lg:py-16">
        <x-ui.breadcrumbs :items="[['label' => 'Alumni', 'url' => url('/alumni')], ['label' => $person->name]]" />
        <div class="mt-8 grid gap-10 sm:grid-cols-3">
            <div>
                <x-ui.image-frame :src="$person->getFirstMediaUrl('photo') ?: null" :alt="$person->name" ratio="aspect-4/5" :grayscale="true" />
            </div>
            <div class="sm:col-span-2">
                <h1 class="text-3xl font-semibold tracking-tight text-ink-900">{{ $person->name }}</h1>
                <p class="mt-2 text-lg text-slate-600">{{ $person->current_position }}</p>
                <div class="mt-4 flex flex-wrap gap-x-6 gap-y-1 text-sm text-slate-500">
                    @if ($person->department_label)<span>Department: <span class="text-ink-900">{{ $person->department_label }}</span></span>@endif
                    @if ($person->batch)<span>Batch: <span class="text-ink-900">{{ $person->batch }}</span></span>@endif
                    @if ($person->graduation_year)<span>Class of <span class="text-ink-900">{{ $person->graduation_year }}</span></span>@endif
                </div>
                @if ($person->bio)
                    <div class="prose prose-slate mt-6 max-w-none">{!! nl2br(e($person->bio)) !!}</div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
