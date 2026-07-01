@props([
    'value',
    'label',
    'suffix' => '+',
])

{{-- Counts up from zero to :value when scrolled into view. --}}
<div
    x-data="{
        n: 0,
        target: {{ (int) $value }},
        run() {
            const step = Math.max(1, Math.ceil(this.target / 60));
            const timer = setInterval(() => {
                this.n += step;
                if (this.n >= this.target) { this.n = this.target; clearInterval(timer); }
            }, 24);
        },
    }"
    x-intersect.once="run()"
    class="text-center"
>
    <div class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
        <span x-text="n.toLocaleString()">0</span><span class="text-amber-400">{{ $suffix }}</span>
    </div>
    <div class="mt-2 text-sm font-medium uppercase tracking-wider text-blue-200">{{ $label }}</div>
</div>
