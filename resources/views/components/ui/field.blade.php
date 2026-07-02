@props(['label' => null, 'name', 'required' => false])

<div class="{{ $attributes->get('class') }}">
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-ink-900">
            {{ $label }}@if ($required)<span class="text-accent-600"> *</span>@endif
        </label>
    @endif
    {{ $slot }}
    @error($name)
        <p class="mt-1 text-sm text-accent-600">{{ $message }}</p>
    @enderror
</div>
