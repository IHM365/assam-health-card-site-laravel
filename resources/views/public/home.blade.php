<x-layouts.public title="Assam Health Card | Affordable Healthcare for Every Family">
    <!-- Modern Hero Banner -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-900 via-primary-800 to-secondary-900 min-h-screen flex items-center">
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl"></div>
            <img src="{{ asset('images/marketing/hero-healthcare.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30" width="1600" height="900" loading="eager" />
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-20 sm:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div>
                        <span class="inline-block px-4 py-2 rounded-full bg-primary-400/20 border border-primary-300/40 text-primary-100 text-sm font-semibold">
                            ✨ Trusted by 50,000+ families
                        </span>
                    </div>

                    <div class="space-y-4">
                        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-tight text-white tracking-tight">
                            Healthcare made <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-200 to-secondary-200">affordable</span>
                        </h1>
                        <p class="text-xl text-white/90 leading-relaxed max-w-xl">
                            Access quality healthcare with discounts at 500+ partner providers across Assam. One card. Endless savings.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        @guest
                            <a href="{{ route('public.contact') }}" class="px-8 py-4 rounded-xl bg-white text-primary-800 font-bold shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                                <span>Get your card</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        @endguest
                        <a href="{{ route('public.about') }}" class="px-8 py-4 rounded-xl border-2 border-white/80 text-white font-bold hover:bg-white/10 transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Learn more</span>
                        </a>
                        @auth
                            @if(auth()->user()->role === \App\Models\User::ROLE_PATIENT)
                                <a href="{{ route('patient.card.show') }}" class="px-8 py-4 rounded-xl bg-white text-primary-800 font-bold shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300">
                                    View my card
                                </a>
                                <a href="#appointment-flow" class="px-8 py-4 rounded-xl border-2 border-white/80 text-white font-bold hover:bg-white/10 transition-all duration-300">
                                    Book appointment
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="px-8 py-4 rounded-xl bg-white text-primary-800 font-bold shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300">
                                    Dashboard
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-8">
                        <div class="space-y-1">
                            <p class="text-2xl font-bold text-white">{{ $stats['vendors'] ?? 500 }}+</p>
                            <p class="text-sm text-white/70">Partners</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-2xl font-bold text-white">{{ $stats['patients'] ?? 50 }}k+</p>
                            <p class="text-sm text-white/70">Families</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-2xl font-bold text-white">{{ $stats['visits'] ?? 100 }}k+</p>
                            <p class="text-sm text-white/70">Visits</p>
                        </div>
                    </div>
                </div>

                <!-- Right Visual Element -->
                <div class="hidden lg:flex justify-center">
                    <div class="relative w-full max-w-md">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-500/20 to-secondary-500/20 rounded-3xl blur-2xl"></div>
                        <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-8 space-y-6">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-primary-500/30 flex items-center justify-center text-2xl">💳</div>
                                    <div>
                                        <p class="text-sm text-white/60">Your Health Card</p>
                                        <p class="font-bold text-white">AHC-2024-0001</p>
                                    </div>
                                </div>
                            </div>
                            <div class="h-px bg-white/10"></div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-white/60">Savings this month</span>
                                    <span class="font-bold text-primary-300">₹2,450</span>
                                </span>
                                <div class="flex justify-between text-sm">
                                    <span class="text-white/60">Partner visits</span>
                                    <span class="font-bold text-secondary-300">12</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-white/60">Active status</span>
                                    <span class="inline-flex items-center gap-1 text-green-300">
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span> Active
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Features -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 mb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-32 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <span class="text-5xl">💳</span>
                </div>
                <div class="p-6 text-center">
                    <p class="font-bold text-slate-900 text-lg">₹299 card</p>
                    <p class="mt-2 text-sm text-slate-600">Special launch pricing (MRP ₹499)</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-32 bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center">
                    <span class="text-5xl">📱</span>
                </div>
                <div class="p-6 text-center">
                    <p class="font-bold text-slate-900 text-lg">QR-based</p>
                    <p class="mt-2 text-sm text-slate-600">Show at checkout, no paperwork</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-32 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <span class="text-5xl">🏥</span>
                </div>
                <div class="p-6 text-center">
                    <p class="font-bold text-slate-900 text-lg">500+ partners</p>
                    <p class="mt-2 text-sm text-slate-600">Across Assam, all verified</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-32 bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center">
                    <span class="text-5xl">💰</span>
                </div>
                <div class="p-6 text-center">
                    <p class="font-bold text-slate-900 text-lg">Instant savings</p>
                    <p class="mt-2 text-sm text-slate-600">Avg ₹450/visit</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="order-2 lg:order-1">
                <p class="text-sm font-semibold text-primary-700 uppercase tracking-wide">How it works</p>
                <h2 class="mt-2 text-3xl font-bold text-slate-900">Three easy steps</h2>
                <p class="mt-3 text-slate-600">Start saving on your family&apos;s healthcare expenses.</p>
                <ol class="mt-8 space-y-6">
                    <li class="flex gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-800 font-bold">1</span>
                        <div>
                            <h3 class="font-semibold text-slate-900">Enrol for Assam Health Card</h3>
                            <p class="mt-1 text-slate-600 text-sm leading-relaxed">Complete enrolment and get your personalised QR-based card. Our team and admin help you activate your account.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-800 font-bold">2</span>
                        <div>
                            <h3 class="font-semibold text-slate-900">Visit partner facilities</h3>
                            <p class="mt-1 text-slate-600 text-sm leading-relaxed">Choose from labs, clinics, diagnostic centres, hospitals, pharmacies, and other services in our network.</p>
                        </div>
                    </li>
                    <li class="flex gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-800 font-bold">3</span>
                        <div>
                            <h3 class="font-semibold text-slate-900">Show your QR &amp; save</h3>
                            <p class="mt-1 text-slate-600 text-sm leading-relaxed">Present your card for instant savings on consultations, tests, and medicines.</p>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="order-1 lg:order-2 rounded-2xl overflow-hidden shadow-xl border border-slate-200 aspect-[4/3]">
                <img src="{{ asset('images/marketing/family-doctor.jpg') }}" alt="Doctor with patient" class="w-full h-full object-cover" loading="lazy" />
            </div>
        </div>
    </section>

    <section class="bg-white border-y border-slate-200 py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto">
                <p class="text-sm font-semibold text-secondary-700 uppercase tracking-wide">Why choose AHC</p>
                <h2 class="mt-2 text-3xl font-bold text-slate-900">Key Benefits</h2>
                <p class="mt-3 text-slate-600">Everything your family needs to access quality care with less financial stress.</p>
            </div>
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-3">💰</div>
                    <h3 class="font-bold text-slate-900 text-lg">Save 30-40%</h3>
                    <p class="mt-2 text-sm text-slate-700 leading-relaxed">Lower out-of-pocket costs with partner discounts. Average savings ₹450 per visit.</p>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-3">🏥</div>
                    <h3 class="font-bold text-slate-900 text-lg">500+ Partners</h3>
                    <p class="mt-2 text-sm text-slate-700 leading-relaxed">Hospitals, clinics, diagnostic centres, pharmacies and labs verified across Assam.</p>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-3">📱</div>
                    <h3 class="font-bold text-slate-900 text-lg">Digital QR Card</h3>
                    <p class="mt-2 text-sm text-slate-700 leading-relaxed">Show QR on phone or print card. Instant verification at every visit.</p>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="text-4xl mb-3">✅</div>
                    <h3 class="font-bold text-slate-900 text-lg">Easy Setup</h3>
                    <p class="mt-2 text-sm text-slate-700 leading-relaxed">Enrol once, get card instantly. No paperwork, no hassle.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Appointment Flow Section -->
    <section id="appointment-flow" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl font-bold text-slate-900">Book an Appointment</h2>
            <p class="mt-4 text-lg text-slate-600">Choose between manual booking or instant QR code scanning at our partner facilities.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Manual Booking Card -->
            <div class="rounded-3xl border-2 border-primary-200 bg-gradient-to-br from-primary-50 to-white p-8 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-primary-100 mb-6">
                    <span class="text-2xl">📋</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Manual Booking</h3>
                <p class="text-slate-600 mb-8">Schedule appointments with detailed information. Get confirmation via SMS and email.</p>

                <div class="bg-white rounded-2xl p-6 space-y-4 border border-slate-200">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Select Provider</label>
                        <select class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                            <option>Choose a provider...</option>
                            <option selected>Dr. Sharma's Clinic - Guwahati</option>
                            <option>Apollo Diagnostics - Dispur</option>
                            <option>Max Hospitals - Guwahati</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Service Type</label>
                        <select class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                            <option>Select service...</option>
                            <option selected>General Consultation</option>
                            <option>Blood Test</option>
                            <option>X-Ray</option>
                            <option>Pharmacy</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700">Date</label>
                            <input type="date" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500" value="2024-03-28" />
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700">Time</label>
                            <input type="time" class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500" value="10:30" />
                        </div>
                    </div>

                    <button class="w-full px-6 py-3 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700 transition-colors">
                        Book Appointment
                    </button>
                </div>

                <div class="mt-6 p-4 rounded-lg bg-primary-50 border border-primary-200">
                    <p class="text-sm text-primary-900"><strong>💡 Tip:</strong> You'll receive a confirmation email and SMS with appointment details.</p>
                </div>
            </div>

            <!-- QR Code Scanning Card -->
            <div class="rounded-3xl border-2 border-secondary-200 bg-gradient-to-br from-secondary-50 to-white p-8 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-secondary-100 mb-6">
                    <span class="text-2xl">📱</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">QR Code Scan</h3>
                <p class="text-slate-600 mb-8">Scan the provider's QR code at their facility to book instantly.</p>

                <div class="bg-white rounded-2xl p-8 border border-slate-200 space-y-6">
                    <div class="flex justify-center">
                        <div class="w-40 h-40 bg-slate-100 rounded-2xl border-4 border-slate-300 flex items-center justify-center">
                            <span class="text-6xl">QR</span>
                        </div>
                    </div>

                    <div class="text-center space-y-2">
                        <p class="text-sm text-slate-600">Step 1: Open your camera</p>
                        <p class="text-sm text-slate-600">Step 2: Scan provider's QR code</p>
                        <p class="text-sm text-slate-600">Step 3: Confirm appointment instantly</p>
                    </div>

                    <button class="w-full px-6 py-3 rounded-lg bg-secondary-600 text-white font-semibold hover:bg-secondary-700 transition-colors">
                        Open Scanner
                    </button>
                </div>

                <div class="mt-6 p-4 rounded-lg bg-secondary-50 border border-secondary-200">
                    <p class="text-sm text-secondary-900"><strong>💡 Benefit:</strong> Instant confirmation without waiting. Perfect for walk-in visits.</p>
                </div>
            </div>
        </div>

        <!-- Recent Appointments Preview -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-slate-900 mb-6">Your Upcoming Appointments</h3>
            <div class="space-y-3">
                <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-start justify-between hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-primary-100 flex items-center justify-center text-xl">🏥</div>
                        <div>
                            <p class="font-semibold text-slate-900">Dr. Sharma's Clinic</p>
                            <p class="text-sm text-slate-600">General Consultation • Tomorrow at 10:30 AM</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span> Confirmed
                    </span>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-start justify-between hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-secondary-100 flex items-center justify-center text-xl">🔬</div>
                        <div>
                            <p class="font-semibold text-slate-900">Apollo Diagnostics</p>
                            <p class="text-sm text-slate-600">Blood Test • March 30 at 9:00 AM</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">
                        <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Scheduled
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-primary-900 via-primary-800 to-secondary-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-black leading-tight">Ready to join 50,000+ families?</h2>
                    <p class="mt-4 text-xl text-white/90">Get your Assam Health Card today and start saving on healthcare. Enrol in minutes, save from day one.</p>
                    <ul class="mt-8 space-y-3">
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-300 rounded-full"></span>
                            <span>Instant enrollment process</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-300 rounded-full"></span>
                            <span>Card activated within 24 hours</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-300 rounded-full"></span>
                            <span>24/7 customer support</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-300 rounded-full"></span>
                            <span>Money-back guarantee</span>
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col gap-4">
                    @guest
                        <a href="{{ route('public.contact') }}" class="px-8 py-4 rounded-xl bg-white text-primary-900 font-bold text-lg text-center hover:bg-primary-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Get Your Card Now
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl border-2 border-white/80 text-white font-bold text-lg text-center hover:bg-white/10 transition-all duration-300">
                            Sign In
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-8 py-4 rounded-xl bg-white text-primary-900 font-bold text-lg text-center hover:bg-primary-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Go to Dashboard
                        </a>
                    @endguest
                    <a href="{{ route('public.vendors') }}" class="px-8 py-4 rounded-xl border-2 border-white/80 text-white font-bold text-lg text-center hover:bg-white/10 transition-all duration-300">
                        Find a Provider
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
