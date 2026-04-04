<footer class="border-t border-slate-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <a href="{{ route('public.home') }}" class="inline-flex items-center gap-2">
                    <img src="{{ asset('images/ahc-logo.svg') }}" alt="" width="40" height="40" class="h-10 w-10 shrink-0" />
                    <span class="font-bold text-slate-900">Assam Health Card</span>
                </a>
                <p class="mt-4 text-sm text-slate-600 leading-relaxed">
                    Partner network includes labs, clinics, diagnostic centres, hospitals, pharmacies, and other healthcare services — so your family saves at every step.
                </p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">For patients</p>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('public.about') }}" class="text-slate-700 hover:text-primary-700">About</a></li>
                    <li><a href="{{ route('public.pricing') }}" class="text-slate-700 hover:text-primary-700">Pricing</a></li>
                    <li><a href="{{ route('public.vendors') }}" class="text-slate-700 hover:text-primary-700">Find providers</a></li>
                    <li><a href="{{ route('public.contact') }}" class="text-slate-700 hover:text-secondary-700">Contact &amp; support</a></li>
                </ul>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">For partners</p>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('public.apply-vendor') }}" class="text-slate-700 hover:text-primary-700">Become a vendor</a></li>
                    <li><a href="{{ route('public.apply-agent') }}" class="text-slate-700 hover:text-primary-700">Become an agent</a></li>
                </ul>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Account</p>
                <ul class="mt-4 space-y-2 text-sm">
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="text-slate-700 hover:text-primary-700">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-slate-700 hover:text-secondary-700">Patient login</a></li>
                        <li class="text-slate-500 text-xs pt-1">New accounts are created by your administrator after you get your card.</li>
                    @endauth
                </ul>
            </div>
        </div>
        <div class="mt-10 flex flex-col gap-2 border-t border-slate-200 pt-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} Assam Health Card. All rights reserved.</p>
            <p class="text-slate-400">AHC — care for every family.</p>
        </div>
    </div>
</footer>
