<x-layouts.app :title="'Admissions — '.config('app.name')" description="Admission process, requirements, and inquiry for NPI University of Bangladesh.">
    <x-ui.page-hero title="Admissions" eyebrow="Join NPIUB" :breadcrumbs="[['label' => 'Admissions']]"
        intro="Everything you need to start your application at NPI University of Bangladesh." />

    <section class="mx-auto max-w-7xl px-4 py-16 lg:px-6 lg:py-20">
        <div class="grid gap-16 lg:grid-cols-12">
            {{-- Left: process + programs --}}
            <div class="lg:col-span-7">
                <x-ui.section-header eyebrow="How to apply" title="A simple, four-step process" />
                <ol class="mt-10 space-y-8">
                    @foreach ([
                        ['Choose your program', 'Explore departments and pick the program that fits your goals.'],
                        ['Submit an inquiry', 'Fill in the form and our admissions team will reach out with details.'],
                        ['Complete your application', 'Provide required documents and academic records.'],
                        ['Enroll', 'Confirm your seat and begin your journey at NPIUB.'],
                    ] as $i => $step)
                        <li class="flex gap-5">
                            <span class="flex h-10 w-10 flex-none items-center justify-center rounded-full border border-slate-300 font-display font-semibold text-ink-900">{{ $i + 1 }}</span>
                            <div>
                                <h3 class="text-lg font-semibold text-ink-900">{{ $step[0] }}</h3>
                                <p class="mt-1 text-slate-600">{{ $step[1] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>

                @if ($programs->isNotEmpty())
                    <div class="mt-14">
                        <h2 class="text-xl font-semibold tracking-tight text-ink-900">Programs you can apply to</h2>
                        <div class="mt-5 divide-y divide-slate-200 border-y border-slate-200">
                            @foreach ($programs as $program)
                                <div class="flex items-center justify-between py-3.5">
                                    <span class="text-ink-900">{{ $program->name }}</span>
                                    <span class="text-xs uppercase tracking-wider text-slate-400">{{ $program->level }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: inquiry form --}}
            <div class="lg:col-span-5">
                <div class="lg:sticky lg:top-28">
                    <div class="border border-slate-200 p-7">
                        <h2 class="text-xl font-semibold tracking-tight text-ink-900">Request information</h2>
                        <p class="mt-1 text-sm text-slate-500">Tell us a little about yourself and we'll be in touch.</p>

                        @if (session('status'))
                            <x-ui.alert class="mt-5">{{ session('status') }}</x-ui.alert>
                        @endif

                        <form method="POST" action="{{ route('admissions.inquiry') }}" class="mt-6 space-y-4">
                            @csrf
                            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                            <x-ui.field label="Full name" name="name" :required="true">
                                <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                            </x-ui.field>
                            <x-ui.field label="Email" name="email" :required="true">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                            </x-ui.field>
                            <x-ui.field label="Phone" name="phone">
                                <input id="phone" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                            </x-ui.field>
                            <x-ui.field label="Program of interest" name="program_id">
                                <select id="program_id" name="program_id" class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                                    <option value="">— Select —</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}" @selected(old('program_id') == $program->id)>{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </x-ui.field>
                            <x-ui.field label="Message" name="message">
                                <textarea id="message" name="message" rows="3" class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">{{ old('message') }}</textarea>
                            </x-ui.field>
                            <x-ui.button type="submit" class="w-full">Submit inquiry</x-ui.button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
