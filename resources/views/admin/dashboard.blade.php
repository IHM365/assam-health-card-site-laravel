<x-layouts.app title="Admin Dashboard | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Dashboard Overview</h1>
                        <p class="text-gray-600 mt-2">Platform performance at a glance</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Last Updated</p>
                            <p class="text-lg font-semibold text-blue-700">Now</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Patients -->
                <div class="animate-slide-in-up" style="animation-delay: 0.1s;">
                    <div class="bg-white rounded-2xl border-2 border-blue-100 p-6 shadow-sm hover:shadow-lg hover:border-blue-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Patients</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($stats['patients'] ?? 0) }}</p>
                                <p class="text-xs text-green-600 font-semibold mt-2">+12.5%</p>
                            </div>
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-user-group class="w-7 h-7 text-blue-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Vendors -->
                <div class="animate-slide-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white rounded-2xl border-2 border-green-100 p-6 shadow-sm hover:shadow-lg hover:border-green-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Vendors</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($stats['activeVendors'] ?? 0) }}</p>
                                <p class="text-xs text-green-600 font-semibold mt-2">+8.2%</p>
                            </div>
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-building-storefront class="w-7 h-7 text-green-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div class="animate-slide-in-up" style="animation-delay: 0.3s;">
                    <div class="bg-white rounded-2xl border-2 border-purple-100 p-6 shadow-sm hover:shadow-lg hover:border-purple-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Monthly Revenue</p>
                                <p class="text-3xl font-bold text-purple-600 mt-2">₹{{ number_format($stats['monthlyRevenue'] ?? 0, 0) }}</p>
                                <p class="text-xs text-green-600 font-semibold mt-2">+15.3%</p>
                            </div>
                            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-banknotes class="w-7 h-7 text-purple-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div class="animate-slide-in-up" style="animation-delay: 0.4s;">
                    <div class="bg-white rounded-2xl border-2 border-orange-100 p-6 shadow-sm hover:shadow-lg hover:border-orange-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Transactions</p>
                                <p class="text-3xl font-bold text-orange-600 mt-2">{{ number_format($stats['visits'] ?? 0) }}</p>
                                <p class="text-xs text-green-600 font-semibold mt-2">+9.8%</p>
                            </div>
                            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-chart-bar class="w-7 h-7 text-orange-600" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activities -->
                <div class="lg:col-span-2 animate-slide-in-up" style="animation-delay: 0.5s;">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <x-heroicon-s-clock class="w-5 h-5 text-blue-600" />
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Recent Activities</h2>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentVisits as $activity)
                                <div class="flex items-start gap-4 pb-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 p-3 rounded-lg transition-smooth">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <x-heroicon-s-currency-dollar class="w-5 h-5 text-blue-600" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div>
                                                <p class="font-semibold text-gray-900 text-sm">
                                                    Visit @ {{ $activity->vendor->name }}
                                                </p>
                                                <p class="text-xs text-gray-600 mt-1">
                                                    Patient: <span class="font-medium">{{ $activity->patient->user->name }}</span> • Discount: <span class="font-semibold text-green-600">₹{{ number_format($activity->discount_amount, 0) }}</span>
                                                </p>
                                            </div>
                                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ $activity->visited_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-8">No recent activities</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="animate-slide-in-up" style="animation-delay: 0.6s;">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-chart-pie class="w-5 h-5 text-green-600" />
                            </div>
                            Quick Stats
                        </h3>

                        <div class="space-y-6">
                            <!-- Vendor Approvals -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Pending Approvals</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold text-orange-700 bg-orange-100">
                                        {{ $stats['pendingVendors'] }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-orange-500 h-2.5 rounded-full" style="width: {{ $stats['pendingVendors'] > 0 ? min(($stats['pendingVendors'] / 20) * 100, 100) : 5 }}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Vendors awaiting approval</p>
                            </div>

                            <!-- Vendor Satisfaction -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Vendor Satisfaction</label>
                                    <span class="text-sm font-bold text-green-600">92%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: 92%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Based on transaction success</p>
                            </div>

                            <!-- Platform Growth -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Platform Growth</label>
                                    <span class="text-sm font-bold text-blue-600">{{ abs($visitGrowth) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ min(abs($visitGrowth), 100) }}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Month-over-month visits increase</p>
                            </div>

                            <!-- Active Rate -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-semibold text-gray-700">Active Users Rate</label>
                                    <span class="text-sm font-bold text-purple-600">78%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-purple-500 h-2.5 rounded-full" style="width: 78%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Users active in last 30 days</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-200 space-y-3">
                            <a href="{{ route('admin.vendors.index') }}" class="block w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-lg font-medium hover:bg-blue-100 transition-smooth text-center text-sm">
                                <x-heroicon-s-check-circle class="w-4 h-4 inline mr-2" />
                                Review Vendors
                            </a>
                            <a href="{{ route('admin.patients.index') }}" class="block w-full px-4 py-3 bg-green-50 text-green-700 rounded-lg font-medium hover:bg-green-100 transition-smooth text-center text-sm">
                                <x-heroicon-s-user-group class="w-4 h-4 inline mr-2" />
                                View Patients
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 animate-slide-in-up" style="animation-delay: 0.7s;">
                <a href="{{ route('admin.visits.index') }}" class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-lg hover:border-blue-300 transition-smooth cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Monthly Visits</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($stats['monthlyVisits'] ?? 0) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <x-heroicon-s-calendar-days class="w-6 h-6 text-blue-600" />
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.vendors.index') }}" class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-lg hover:border-green-300 transition-smooth cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">All Vendors</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($stats['vendors'] ?? 0) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <x-heroicon-s-building-storefront class="w-6 h-6 text-green-600" />
                        </div>
                    </div>
                </a>

                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">₹{{ number_format($stats['totalRevenue'] ?? 0, 0) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <x-heroicon-s-banknotes class="w-6 h-6 text-purple-600" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

