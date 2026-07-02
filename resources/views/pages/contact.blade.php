<x-layouts.app :title="'Contact — '.config('app.name')" description="Get in touch with NPI University of Bangladesh.">
    <x-ui.page-hero title="Contact Us" eyebrow="Get in Touch" :breadcrumbs="[['label' => 'Contact']]"
        intro="We'd love to hear from you. Reach out with any questions." />

    <section class="mx-auto max-w-7xl px-4 py-16 lg:px-6 lg:py-20">
        <div class="grid gap-14 lg:grid-cols-12">
            {{-- Info --}}
            <div class="lg:col-span-5">
                <dl class="space-y-8">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Address</dt>
                        <dd class="mt-2 text-lg text-ink-900">{{ \App\Models\SiteSetting::get('contact', 'address', 'Dhaka, Bangladesh') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Phone</dt>
                        <dd class="mt-2 text-lg text-ink-900">{{ \App\Models\SiteSetting::get('contact', 'phone', '+880 1XXX-XXXXXX') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Email</dt>
                        <dd class="mt-2 text-lg text-ink-900">{{ \App\Models\SiteSetting::get('contact', 'email', 'info@npiub.edu.bd') }}</dd>
                    </div>
                </dl>
                <div id="location" class="mt-10 aspect-video w-full overflow-hidden rounded-lg bg-slate-100">
                    @php $map = \App\Models\SiteSetting::get('contact', 'map_embed'); @endphp
                    @if ($map)
                        {!! $map !!}
                    @else
                        <div class="flex h-full w-full items-center justify-center text-slate-400">Map location</div>
                    @endif
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-6 lg:col-start-7">
                <h2 class="text-2xl font-semibold tracking-tight text-ink-900">Send a message</h2>

                @if (session('status'))
                    <x-ui.alert class="mt-5">{{ session('status') }}</x-ui.alert>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-ui.field label="Full name" name="name" :required="true">
                            <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                        </x-ui.field>
                        <x-ui.field label="Email" name="email" :required="true">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                        </x-ui.field>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-ui.field label="Phone" name="phone">
                            <input id="phone" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                        </x-ui.field>
                        <x-ui.field label="Subject" name="subject">
                            <input id="subject" name="subject" value="{{ old('subject') }}" class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">
                        </x-ui.field>
                    </div>
                    <x-ui.field label="Message" name="message" :required="true">
                        <textarea id="message" name="message" rows="5" required class="w-full rounded-md border border-slate-300 px-4 py-2.5 text-sm focus:border-ink-900 focus:outline-none">{{ old('message') }}</textarea>
                    </x-ui.field>
                    <x-ui.button type="submit" size="lg">Send message</x-ui.button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
