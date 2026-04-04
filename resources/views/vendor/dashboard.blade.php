@extends('vendor.layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50">
        <div class="max-w-7xl">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Welcome, {{ $vendor->user->name }}!</h1>
                        <p class="text-gray-600 mt-2">Here's your business overview</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="text-lg font-semibold {{ $vendor->status === 'approved' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($vendor->status) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Patients Today -->
                <div class="animate-slide-in-up" style="animation-delay: 0.1s;">
                    <div class="bg-white rounded-2xl border-2 border-blue-100 p-6 shadow-sm hover:shadow-lg hover:border-blue-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Patients Today</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['todayVisits'] ?? 0 }}</p>
                                <p class="text-xs text-green-600 font-semibold mt-2">+{{ $stats['todayIncrease'] ?? 0 }}%</p>
                            </div>
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-user class="w-7 h-7 text-blue-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bills This Month -->
                <div class="animate-slide-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white rounded-2xl border-2 border-green-100 p-6 shadow-sm hover:shadow-lg hover:border-green-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Bills This Month</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($stats['monthlyBills'] ?? 0) }}</p>
                                <p class="text-xs text-green-600 font-semibold mt-2">+{{ $stats['billsIncrease'] ?? 8 }}%</p>
                            </div>
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-document-text class="w-7 h-7 text-green-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue This Month -->
                <div class="animate-slide-in-up" style="animation-delay: 0.3s;">
                    <div class="bg-white rounded-2xl border-2 border-purple-100 p-6 shadow-sm hover:shadow-lg hover:border-purple-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Revenue This Month</p>
                                <p class="text-3xl font-bold text-purple-600 mt-2">₹{{ number_format($stats['monthlyRevenue'] ?? 0, 0) }}</p>
                                <p class="text-xs text-green-600 font-semibold mt-2">+{{ $stats['revenueIncrease'] ?? 15 }}%</p>
                            </div>
                            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-banknotes class="w-7 h-7 text-purple-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Settlement -->
                <div class="animate-slide-in-up" style="animation-delay: 0.4s;">
                    <div class="bg-white rounded-2xl border-2 border-orange-100 p-6 shadow-sm hover:shadow-lg hover:border-orange-300 transition-smooth">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Pending Settlement</p>
                                <p class="text-3xl font-bold text-orange-600 mt-2">₹{{ number_format($stats['pendingSettlement'] ?? 0, 0) }}</p>
                                <p class="text-xs text-gray-600 font-semibold mt-2">From {{ $stats['pendingVisits'] ?? 0 }} visits</p>
                            </div>
                            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                                <x-heroicon-s-chart-bar class="w-7 h-7 text-orange-600" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Transactions -->
                <div class="lg:col-span-2 animate-slide-in-up" style="animation-delay: 0.5s;">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <x-heroicon-s-clock class="w-5 h-5 text-blue-600" />
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Recent Transactions</h2>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="border-b border-gray-200">
                                    <tr>
                                        <th class="text-left text-xs font-semibold text-gray-600 uppercase px-4 py-3">Date</th>
                                        <th class="text-left text-xs font-semibold text-gray-600 uppercase px-4 py-3">Patient</th>
                                        <th class="text-left text-xs font-semibold text-gray-600 uppercase px-4 py-3">Card ID</th>
                                        <th class="text-left text-xs font-semibold text-gray-600 uppercase px-4 py-3">Service</th>
                                        <th class="text-right text-xs font-semibold text-gray-600 uppercase px-4 py-3">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($recentVisits as $visit)
                                        <tr class="hover:bg-gray-50 transition-smooth">
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $visit->visited_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $visit->patient->user->name }}</td>
                                            <td class="px-4 py-3 text-sm font-mono text-gray-600">AHC-2026-{{ str_pad($visit->patient_id, 5, '0', STR_PAD_LEFT) }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700">{{ $visit->service_type ?? 'Consultation' }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold text-green-600 text-right">₹{{ number_format($visit->discount_amount, 0) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No recent transactions</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="animate-slide-in-up" style="animation-delay: 0.6s;">
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-bolt class="w-5 h-5 text-blue-600" />
                            </div>
                            Quick Actions
                        </h3>

                        <a href="{{ route('vendor.scan.index') }}" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-smooth font-semibold">
                            <x-heroicon-s-qr-code class="w-5 h-5" />
                            <span>Scan Card</span>
                            <x-heroicon-s-arrow-right class="w-4 h-4 ml-auto" />
                        </a>

                        <a href="{{ route('vendor.visits.index') }}" class="flex items-center gap-3 px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-smooth font-semibold">
                            <x-heroicon-s-clock class="w-5 h-5" />
                            <span>View History</span>
                            <x-heroicon-s-arrow-right class="w-4 h-4 ml-auto" />
                        </a>

                        <!-- Upload Bill Disabled -->

                        <a href="{{ route('vendor.reports.monthly') }}" class="flex items-center gap-3 px-4 py-3 bg-orange-50 text-orange-700 rounded-lg hover:bg-orange-100 transition-smooth font-semibold">
                            <x-heroicon-s-chart-bar class="w-5 h-5" />
                            <span>Monthly Reports</span>
                            <x-heroicon-s-arrow-right class="w-4 h-4 ml-auto" />
                        </a>

                        <a href="{{ route('vendor.payments.history') }}" class="flex items-center gap-3 px-4 py-3 bg-pink-50 text-pink-700 rounded-lg hover:bg-pink-100 transition-smooth font-semibold">
                            <x-heroicon-s-currency-rupee class="w-5 h-5" />
                            <span>Payment History</span>
                            <x-heroicon-s-arrow-right class="w-4 h-4 ml-auto" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
