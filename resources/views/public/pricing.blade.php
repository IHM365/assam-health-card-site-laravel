<x-layouts.public title="Pricing | Assam Health Card" metaDescription="Assam Health Card pricing — special offer ₹299 (MRP ₹499). Transparent discounts at partner labs, clinics, diagnostic centres, hospitals, and pharmacies.">
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 border-b border-slate-200">
        <div class="absolute right-0 top-0 w-1/2 max-w-lg h-full opacity-30 hidden lg:block">
            <img src="{{ asset('images/marketing/family-doctor.jpg') }}" alt="" class="h-full w-full object-cover object-left rounded-bl-3xl" loading="lazy" />
        </div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-16 text-center relative">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Simple, transparent pricing</h1>
            <p class="mt-4 text-lg text-slate-600 max-w-2xl mx-auto">
                One card for your family — discounts at partner labs, clinics, diagnostic centres, hospitals, pharmacies, and other healthcare services across Assam.
            </p>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="rounded-3xl border-2 border-primary-200 bg-white p-8 sm:p-10 shadow-lg shadow-primary-900/5 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-primary-700">For patients &amp; families</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">Assam Health Card</h2>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Enrol once, carry your digital QR card everywhere, and unlock discounts at approved partners. Accounts are created by our team when you enrol — no public self-registration.
                    </p>
                    <ul class="mt-8 space-y-3 text-slate-700">
                        <li class="flex gap-3">
                            <span class="text-primary-600 font-bold">✓</span>
                            <span>QR-based health card linked to your patient profile</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-primary-600 font-bold">✓</span>
                            <span>Discounts on consultations, diagnostics, and medicines at partner facilities</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-primary-600 font-bold">✓</span>
                            <span>Network includes labs, clinics, diagnostic centres, hospitals, pharmacies &amp; more</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="text-primary-600 font-bold">✓</span>
                            <span>Visit history and verification in your patient account after login</span>
                        </li>
                    </ul>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-primary-50 to-secondary-50 border border-primary-100 p-8 text-center">
                    <p class="text-sm font-medium text-slate-500 line-through">MRP ₹499</p>
                    <p class="mt-1 text-5xl font-extrabold text-primary-700">₹299</p>
                    <p class="mt-2 text-sm font-semibold text-secondary-700">Limited-time offer</p>
                    <p class="mt-4 text-sm text-slate-600">Card fee covers enrolment and your digital QR card. Partner discounts apply at point of care.</p>
                    <div class="mt-8 flex flex-col gap-3">
                        @guest
                            <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-primary-600 text-white font-semibold hover:bg-primary-700 shadow-sm">
                                Enquire to enrol
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl border-2 border-secondary-500 text-secondary-800 font-semibold hover:bg-secondary-50">
                                Already have account? Login
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-primary-600 text-white font-semibold hover:bg-primary-700 shadow-sm">
                                Open my account
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white shadow-sm">
                <img src="{{ asset('images/marketing/pharmacy.jpg') }}" alt="" class="h-40 w-full object-cover" loading="lazy" />
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900">Healthcare providers &amp; partners</h3>
                    <p class="mt-2 text-slate-600 text-sm leading-relaxed">
                        Labs, clinics, diagnostic centres, hospitals, pharmacies, and other healthcare services can join the network. Onboarding is coordinated by our team.
                    </p>
                    <a href="{{ route('public.apply-vendor') }}" class="mt-4 inline-flex text-sm font-semibold text-secondary-700 hover:text-secondary-900">
                        Become a vendor →
                    </a>
                </div>
            </div>
            <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white shadow-sm">
                <img src="{{ asset('images/marketing/hospital-building.jpg') }}" alt="" class="h-40 w-full object-cover" loading="lazy" />
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900">Questions?</h3>
                    <p class="mt-2 text-slate-600 text-sm leading-relaxed">
                        Ask about enrolment, pricing, or finding a provider near you.
                    </p>
                    <a href="{{ route('public.contact') }}" class="mt-4 inline-flex text-sm font-semibold text-primary-700 hover:text-primary-900">
                        Contact support →
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
