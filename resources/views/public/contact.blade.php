<x-layouts.public title="Contact | Assam Health Card" metaDescription="Contact Assam Health Card for enrolment, your card, or finding a provider.">
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="rounded-2xl overflow-hidden border border-slate-200 mb-10 aspect-[21/9] max-h-48">
            <img src="{{ asset('images/marketing/pharmacy.jpg') }}" alt="" class="w-full h-full object-cover" loading="lazy" />
        </div>
        <h1 class="text-3xl font-bold text-slate-900">Contact us</h1>
        <p class="mt-2 text-slate-600">Questions about enrolment, pricing, your card, or finding a provider? Send us a message — we&apos;re here to help patients and families.</p>

        @if (session('status'))
            <div class="mt-6 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('public.contact.submit') }}" class="mt-6 bg-white border border-slate-200 rounded-xl p-6 space-y-5">
            @csrf

            <div>
                <x-input-label for="name" value="Name" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="message" value="Message" />
                <textarea id="message" name="message" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-secondary-500 focus:ring-secondary-500" required>{{ old('message') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('message')" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-secondary-600 text-white text-sm font-semibold hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2">
                    Send message
                </button>
            </div>
        </form>
    </section>
</x-layouts.public>

