<x-layouts.app title="Patient Dashboard | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Section -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                            Welcome Back, {{ $patient->name }}!
                        </h1>
                        <p class="text-gray-600 mt-2">Here's your health card overview</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Patient ID</p>
                            <p class="text-lg font-semibold text-green-700">{{ $patient->id }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <x-heroicon-s-user class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Visits Card -->
                <div class="animate-slide-in-up" style="animation-delay: 0.1s;">
                    <div class="bg-white rounded-2xl border-2 border-blue-100 p-6 shadow-sm hover:shadow-lg hover:border-blue-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Visits This Year</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalVisits ?? 0 }}</p>
                            </div>
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-calendar-days class="w-7 h-7 text-blue-600" />
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-4">Medical visits and check-ups</p>
                    </div>
                </div>

                <!-- Total Savings Card -->
                <div class="animate-slide-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white rounded-2xl border-2 border-green-100 p-6 shadow-sm hover:shadow-lg hover:border-green-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Savings</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">₹{{ number_format($totalSavings ?? 0, 0) }}</p>
                            </div>
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-banknotes class="w-7 h-7 text-green-600" />
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-4">Amount saved on discounts</p>
                    </div>
                </div>

                <!-- Card Valid Until Card -->
                <div class="animate-slide-in-up" style="animation-delay: 0.3s;">
                    <div class="bg-white rounded-2xl border-2 border-purple-100 p-6 shadow-sm hover:shadow-lg hover:border-purple-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Card Valid Until</p>
                                <p class="text-2xl font-bold text-purple-600 mt-2">Dec 2026</p>
                            </div>
                            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-calendar class="w-7 h-7 text-purple-600" />
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-4">{{ now()->diffInDays('2026-12-31') }} days remaining</p>
                    </div>
                </div>

                <!-- Card Status Card -->
                <div class="animate-slide-in-up" style="animation-delay: 0.4s;">
                    <div class="bg-white rounded-2xl border-2 border-emerald-100 p-6 shadow-sm hover:shadow-lg hover:border-emerald-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Card Status</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                                    <p class="text-2xl font-bold text-emerald-600">{{ ucfirst($patient->status ?? 'Active') }}</p>
                                </div>
                            </div>
                            <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-check-circle class="w-7 h-7 text-emerald-600" />
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-4">Ready to use</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Visits Section -->
                <div class="lg:col-span-2 animate-slide-in-up" style="animation-delay: 0.5s;">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <x-heroicon-s-clock class="w-5 h-5 text-blue-600" />
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Recent Visits</h2>
                            </div>
                            @if($visits->count() > 0)
                                <a href="{{ route('patient.visits.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                                    View All →
                                </a>
                            @endif
                        </div>

                        @if($visits->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Healthcare Provider</th>
                                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Discount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($visits->take(5) as $visit)
                                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-smooth">
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                            <x-heroicon-s-building-library class="w-4 h-4 text-green-600" />
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-gray-900">{{ $visit->vendor->name ?? $visit->vendor->user->name }}</p>
                                                            <p class="text-xs text-gray-500">
                                                                {{ $visit->service_type ?? $visit->vendor->type }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-600">
                                                    {{ $visit->visited_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-4 py-4 text-right">
                                                    <div class="text-right">
                                                        <p class="font-semibold text-green-600">₹{{ number_format($visit->discount_amount, 0) }}</p>
                                                        <p class="text-xs text-gray-500">{{ $visit->discount_percentage }}%</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <x-heroicon-s-inbox class="w-8 h-8 text-gray-400" />
                                </div>
                                <p class="text-gray-600 font-medium">No visits yet</p>
                                <p class="text-sm text-gray-500 mt-1">Your visit history will appear here</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions Sidebar -->
                <div class="space-y-6 animate-slide-in-up" style="animation-delay: 0.6s;">
                    <!-- View Card -->
                    <a href="{{ route('patient.card.show') }}" class="block">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl hover:scale-105 transition-smooth cursor-pointer">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">View My Card</h3>
                                <x-heroicon-s-document class="w-6 h-6" />
                            </div>
                            <p class="text-blue-100 text-sm">Access your digital health card with QR code</p>
                        </div>
                    </a>

                    <!-- Edit Profile -->
                    <a href="{{ route('profile.edit') }}" class="block">
                        <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl hover:scale-105 transition-smooth cursor-pointer">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Edit Profile</h3>
                                <x-heroicon-s-pencil-square class="w-6 h-6" />
                            </div>
                            <p class="text-green-100 text-sm">Update your personal information</p>
                        </div>
                    </a>

                    <!-- Find Partners -->
                    <a href="{{ route('patient.vendors.index') }}" class="block">
                        <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl hover:scale-105 transition-smooth cursor-pointer">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold">Find Partners</h3>
                                <x-heroicon-s-map-pin class="w-6 h-6" />
                            </div>
                            <p class="text-purple-100 text-sm">Browse hospitals and clinics near you</p>
                        </div>
                    </a>

                    <!-- Renew Card -->
                    <div class="bg-gray-100 rounded-2xl p-6 border-2 border-dashed border-gray-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Renew Card</h3>
                            <x-heroicon-s-arrow-path class="w-6 h-6 text-gray-700" />
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Renew your health card before it expires</p>
                        <button class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg font-medium cursor-not-allowed opacity-50">
                            Coming Soon
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

