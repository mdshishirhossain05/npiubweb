@props(['program'])

<x-ui.card href="{{ url('/departments/'.($program->department?->slug ?? '')) }}" class="p-6">
    <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-lg bg-primary-100 text-primary-700">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z M12 14v7 M5 11v4c0 1 3 3 7 3s7-2 7-3v-4"/></svg>
    </div>
    <x-ui.badge color="secondary">{{ ucfirst($program->level) }}</x-ui.badge>
    <h3 class="mt-2 font-semibold text-slate-900 group-hover:text-primary-700">{{ $program->name }}</h3>
    @if ($program->department)
        <p class="mt-1 text-sm text-slate-500">{{ $program->department->name }}</p>
    @endif
</x-ui.card>
