<x-layouts.public title="Find providers | Assam Health Card" metaDescription="Browse approved clinics, labs, hospitals, and pharmacies in the Assam Health Card network.">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-900 to-secondary-900 text-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl sm:text-6xl font-black leading-tight">Find a Provider</h1>
            <p class="mt-4 text-xl text-white/90 max-w-2xl">Browse 500+ approved hospitals, clinics, diagnostic centers, pharmacies and labs in our network. All verified. All discounted.</p>
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-8 relative z-10 mb-12">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Search provider</label>
                    <input type="text" placeholder="Search by name..." class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Provider type</label>
                    <select class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                        <option value="">All types</option>
                        <option>Clinic</option>
                        <option>Hospital</option>
                        <option>Diagnostic Center</option>
                        <option>Pharmacy</option>
                        <option>Lab</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Location</label>
                    <select class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                        <option value="">All locations</option>
                        <option>Guwahati</option>
                        <option>Dispur</option>
                        <option>Dibrugarh</option>
                        <option>Silchar</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button class="flex-1 px-6 py-3 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700 transition-colors">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Provider Cards -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Sample Provider 1 -->
            <a href="{{ route('public.vendors.show', 1) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-primary-300 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <span class="text-5xl">🏥</span>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                            Hospital
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                            35% OFF
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 mt-3">Apollo Hospitals Guwahati</h3>
                    <p class="text-sm text-slate-600 mt-2 flex items-center gap-1">
                        📍 GS Road, Guwahati
                    </p>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-600">⭐ 4.8 (240 reviews)</span>
                        <span class="text-primary-600 font-semibold">View details →</span>
                    </div>
                </div>
            </a>

            <!-- Sample Provider 2 -->
            <a href="{{ route('public.vendors.show', 2) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-secondary-300 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center">
                    <span class="text-5xl">🔬</span>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                            Diagnostic
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                            40% OFF
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 mt-3">SRL Diagnostics</h3>
                    <p class="text-sm text-slate-600 mt-2 flex items-center gap-1">
                        📍 Dispur, Guwahati
                    </p>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-600">⭐ 4.9 (180 reviews)</span>
                        <span class="text-primary-600 font-semibold">View details →</span>
                    </div>
                </div>
            </a>

            <!-- Sample Provider 3 -->
            <a href="{{ route('public.vendors.show', 3) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-green-300 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                    <span class="text-5xl">💊</span>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            Pharmacy
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                            20% OFF
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 mt-3">Medlife Pharmacy</h3>
                    <p class="text-sm text-slate-600 mt-2 flex items-center gap-1">
                        📍 Beltola, Guwahati
                    </p>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-600">⭐ 4.6 (320 reviews)</span>
                        <span class="text-primary-600 font-semibold">View details →</span>
                    </div>
                </div>
            </a>

            <!-- Sample Provider 4 -->
            <a href="{{ route('public.vendors.show', 4) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-primary-300 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <span class="text-5xl">🏥</span>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                            Clinic
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                            30% OFF
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 mt-3">Dr. Sharma's Clinic</h3>
                    <p class="text-sm text-slate-600 mt-2 flex items-center gap-1">
                        📍 Paltan Bazar, Guwahati
                    </p>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-600">⭐ 4.7 (150 reviews)</span>
                        <span class="text-primary-600 font-semibold">View details →</span>
                    </div>
                </div>
            </a>

            <!-- Sample Provider 5 -->
            <a href="{{ route('public.vendors.show', 5) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-secondary-300 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center">
                    <span class="text-5xl">🔬</span>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">
                            Lab
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                            38% OFF
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 mt-3">Care Diagnostics</h3>
                    <p class="text-sm text-slate-600 mt-2 flex items-center gap-1">
                        📍 Uzanbazar, Guwahati
                    </p>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-600">⭐ 4.8 (200 reviews)</span>
                        <span class="text-primary-600 font-semibold">View details →</span>
                    </div>
                </div>
            </a>

            <!-- Sample Provider 6 -->
            <a href="{{ route('public.vendors.show', 6) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-green-300 transition-all duration-300">
                <div class="h-32 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                    <span class="text-5xl">💊</span>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                            Pharmacy
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                            25% OFF
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-primary-700 mt-3">Apollo Pharmacy</h3>
                    <p class="text-sm text-slate-600 mt-2 flex items-center gap-1">
                        📍 Kamrup, Guwahati
                    </p>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="text-slate-600">⭐ 4.5 (280 reviews)</span>
                        <span class="text-primary-600 font-semibold">View details →</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Load More Button -->
        <div class="mt-12 text-center">
            <button class="px-8 py-3 rounded-xl border-2 border-primary-600 text-primary-600 font-bold hover:bg-primary-50 transition-colors">
                Load More Providers
            </button>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-slate-50 border-y border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="text-4xl font-black text-primary-700">500+</p>
                    <p class="text-sm text-slate-600 mt-2">Verified Providers</p>
                </div>
                <div>
                    <p class="text-4xl font-black text-primary-700">50,000+</p>
                    <p class="text-sm text-slate-600 mt-2">Happy Families</p>
                </div>
                <div>
                    <p class="text-4xl font-black text-primary-700">₹50M+</p>
                    <p class="text-sm text-slate-600 mt-2">Savings Generated</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>

