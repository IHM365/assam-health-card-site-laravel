<x-layouts.public title="{{ $vendor->name }} | Assam Health Card">
    <!-- Hero Section with Background -->
    <section class="relative h-64 sm:h-80 bg-gradient-to-r from-primary-600 to-secondary-600 overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23000%22 fill-opacity=%220.1%22%3E%3Cpath d=%22M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-50 via-transparent to-transparent"></div>
    </section>

    <!-- Main Content -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative z-10 pb-16">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">
            <!-- Header Section -->
            <div class="px-6 sm:px-10 py-8 sm:py-12 border-b border-slate-200">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 items-start">
                    <!-- Provider Logo/Avatar -->
                    <div class="sm:col-span-1">
                        <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center text-7xl shadow-lg border-4 border-white">
                            🏥
                        </div>
                    </div>

                    <!-- Provider Info -->
                    <div class="sm:col-span-3">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        🏥 Hospital
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        ✓ Verified
                                    </span>
                                </div>
                                <h1 class="text-4xl font-black text-slate-900">Apollo Hospitals Guwahati</h1>
                                <p class="mt-3 text-lg text-slate-600">Multi-specialty tertiary care hospital with 24/7 emergency services</p>
                                
                                <!-- Quick Stats -->
                                <div class="mt-6 flex flex-wrap gap-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl">⭐</span>
                                        <span><strong>4.8</strong>/5 (248 reviews)</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl">📍</span>
                                        <span>GS Road, Guwahati</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl">🔗</span>
                                        <span>ID: AHC-HOS-001</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Discount Badge -->
                            <div class="bg-gradient-to-br from-emerald-50 to-green-50 border-2 border-emerald-200 rounded-2xl px-6 py-6 text-center min-w-max">
                                <p class="text-xs text-emerald-700 font-semibold uppercase tracking-wide">Discount</p>
                                <p class="mt-1 text-5xl font-black text-emerald-700">35%</p>
                                <p class="mt-1 text-xs text-emerald-600">On all services</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 sm:p-10">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Contact & Hours -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl border border-slate-200 p-6 space-y-4">
                        <h2 class="text-xl font-bold text-slate-900">Contact & Hours</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase tracking-wide">Phone</p>
                                <p class="mt-2 text-lg font-semibold text-slate-900">+91-361-2567890</p>
                                <p class="text-sm text-slate-600 mt-1">24/7 availability</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase tracking-wide">Email</p>
                                <p class="mt-2 text-sm text-slate-900 break-all">contact@apollohospitals.com</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase tracking-wide">Operating Hours</p>
                                <p class="mt-2 text-sm text-slate-900"><strong>24 hours</strong> (24/7 Services)</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 font-semibold uppercase tracking-wide">Emergency</p>
                                <p class="mt-2 text-sm text-slate-900">+91-361-2567891</p>
                            </div>
                        </div>
                    </div>

                    <!-- Services Offered -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                        <h2 class="text-xl font-bold text-slate-900">Services Offered</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center hover:shadow-md transition">
                                <p class="text-2xl mb-1">🏥</p>
                                <p class="text-sm font-semibold text-slate-900">General Ward</p>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center hover:shadow-md transition">
                                <p class="text-2xl mb-1">🔬</p>
                                <p class="text-sm font-semibold text-slate-900">Diagnostics</p>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 text-center hover:shadow-md transition">
                                <p class="text-2xl mb-1">🏥</p>
                                <p class="text-sm font-semibold text-slate-900">ICU Services</p>
                            </div>
                            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 text-center hover:shadow-md transition">
                                <p class="text-2xl mb-1">🩺</p>
                                <p class="text-sm font-semibold text-slate-900">Cardiology</p>
                            </div>
                            <div class="bg-cyan-50 border border-cyan-200 rounded-xl p-4 text-center hover:shadow-md transition">
                                <p class="text-2xl mb-1">🧠</p>
                                <p class="text-sm font-semibold text-slate-900">Neurology</p>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center hover:shadow-md transition">
                                <p class="text-2xl mb-1">👶</p>
                                <p class="text-sm font-semibold text-slate-900">Pediatrics</p>
                            </div>
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                        <h2 class="text-xl font-bold text-slate-900">Facilities</h2>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <span class="text-2xl flex-shrink-0">✅</span>
                                <span class="text-slate-700"><strong>Advanced ICU:</strong> 30 bed capacity with latest ventilators</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-2xl flex-shrink-0">✅</span>
                                <span class="text-slate-700"><strong>Emergency Department:</strong> 24-hour trauma care</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-2xl flex-shrink-0">✅</span>
                                <span class="text-slate-700"><strong>Operating Theaters:</strong> 8 fully equipped modern OTs</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-2xl flex-shrink-0">✅</span>
                                <span class="text-slate-700"><strong>Diagnostic Center:</strong> CT, MRI, Ultrasound, X-Ray</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-2xl flex-shrink-0">✅</span>
                                <span class="text-slate-700"><strong>Cafeteria & Parking:</strong> Free parking for patients</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="text-2xl flex-shrink-0">✅</span>
                                <span class="text-slate-700"><strong>Ambulance Services:</strong> Advanced life support ambulances</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Departments -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                        <h2 class="text-xl font-bold text-slate-900">Key Departments</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition">
                                <p class="font-semibold text-slate-900">Cardiology</p>
                                <p class="text-sm text-slate-600 mt-1">Dr. Rajesh Kumar (Chief)</p>
                                <p class="text-xs text-slate-500 mt-2">20+ years experience</p>
                            </div>
                            <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition">
                                <p class="font-semibold text-slate-900">Neurology</p>
                                <p class="text-sm text-slate-600 mt-1">Dr. Priya Sharma (Chief)</p>
                                <p class="text-xs text-slate-500 mt-2">15+ years experience</p>
                            </div>
                            <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition">
                                <p class="font-semibold text-slate-900">Orthopedics</p>
                                <p class="text-sm text-slate-600 mt-1">Dr. Amit Singh (Chief)</p>
                                <p class="text-xs text-slate-500 mt-2">18+ years experience</p>
                            </div>
                            <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition">
                                <p class="font-semibold text-slate-900">Pediatrics</p>
                                <p class="text-sm text-slate-600 mt-1">Dr. Anjali Dutta (Chief)</p>
                                <p class="text-xs text-slate-500 mt-2">12+ years experience</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button class="w-full px-6 py-4 rounded-xl bg-primary-600 text-white font-bold text-lg hover:bg-primary-700 transition-colors shadow-lg">
                            Book Appointment
                        </button>
                        <button class="w-full px-6 py-4 rounded-xl border-2 border-primary-600 text-primary-600 font-bold hover:bg-primary-50 transition-colors">
                            Call Hospital
                        </button>
                        <button class="w-full px-6 py-4 rounded-xl border-2 border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition-colors">
                            Share Profile
                        </button>
                    </div>

                    <!-- Key Info Cards -->
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl border border-primary-200 p-6 space-y-4">
                        <h3 class="font-bold text-slate-900">Partner Info</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Partner ID</p>
                                <p class="mt-1 font-semibold text-slate-900">AHC-HOS-001</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Joined Since</p>
                                <p class="mt-1 font-semibold text-slate-900">Jan 2024</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Patients Served</p>
                                <p class="mt-1 font-semibold text-slate-900">12,450+</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Total Discounts</p>
                                <p class="mt-1 font-semibold text-primary-700">₹45.2 Lakhs</p>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Info -->
                    <div class="bg-gradient-to-br from-emerald-50 to-green-100 rounded-2xl border border-emerald-200 p-6 space-y-3">
                        <h3 class="font-bold text-slate-900">Current Offers</h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-slate-700"><strong>General Consultation:</strong> 30% off</p>
                            <p class="text-slate-700"><strong>Diagnostics:</strong> 35% off</p>
                            <p class="text-slate-700"><strong>Surgery Packages:</strong> Special rates</p>
                            <p class="text-slate-700"><strong>Cashback:</strong> Additional 5%</p>
                        </div>
                    </div>

                    <!-- Accreditations -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4">
                        <h3 class="font-bold text-slate-900">Accreditations</h3>
                        <div class="space-y-2 text-sm">
                            <p class="flex items-center gap-2"><span class="text-xl">✓</span> <span>NABH Accredited</span></p>
                            <p class="flex items-center gap-2"><span class="text-xl">✓</span> <span>ISO 15189 Certified</span></p>
                            <p class="flex items-center gap-2"><span class="text-xl">✓</span> <span>JCI Approved</span></p>
                            <p class="flex items-center gap-2"><span class="text-xl">✓</span> <span>IAMAI Member</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="border-t border-slate-200 px-6 sm:px-10 py-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Recent Reviews</h2>
                <div class="space-y-4">
                    <div class="border border-slate-200 rounded-xl p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="font-semibold text-slate-900">Rajesh Gupta</p>
                                <p class="text-xs text-slate-500">Verified Patient • 2 weeks ago</p>
                            </div>
                            <span class="text-yellow-400">★★★★★</span>
                        </div>
                        <p class="text-slate-700 text-sm">Excellent hospital with very professional staff. Got 35% discount on my cardiac checkup. Highly recommended!</p>
                    </div>
                    <div class="border border-slate-200 rounded-xl p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="font-semibold text-slate-900">Priya Das</p>
                                <p class="text-xs text-slate-500">Verified Patient • 1 month ago</p>
                            </div>
                            <span class="text-yellow-400">★★★★☆</span>
                        </div>
                        <p class="text-slate-700 text-sm">Great service and facilities. The discount through AHC helped us save a lot on diagnostics. Will definitely use again.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('public.vendors') }}" class="inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold">
                ← Back to Providers
            </a>
        </div>
    </section>
</x-layouts.public>

