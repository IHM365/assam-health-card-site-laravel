<x-layouts.app title="Visit History | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Visit History</h1>
                        <p class="text-gray-600 mt-2">All your healthcare visits and discounts</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                            <x-heroicon-s-arrow-left class="w-5 h-5" />
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>

            @if($visits->count() > 0)
                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-slide-in-up" style="animation-delay: 0.1s;">
                    <div class="bg-white rounded-xl border border-blue-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Visits</p>
                                <p class="text-2xl font-bold text-blue-600 mt-2">{{ $visits->total() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-calendar-days class="w-6 h-6 text-blue-600" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-green-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Savings</p>
                                <p class="text-2xl font-bold text-green-600 mt-2">₹{{ number_format($visits->sum('discount_amount'), 0) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-banknotes class="w-6 h-6 text-green-600" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-purple-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Average Discount</p>
                                <p class="text-2xl font-bold text-purple-600 mt-2">{{ number_format($visits->avg('discount_percentage'), 1) }}%</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-chart-bar class="w-6 h-6 text-purple-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visits Table -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-slide-in-up" style="animation-delay: 0.2s;">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Healthcare Provider</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Type</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Bill Amount</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Discount</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Amount Saved</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($visits as $visit)
                                    <tr class="hover:bg-gray-50 transition-smooth">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                    <x-heroicon-s-calendar class="w-5 h-5 text-blue-600" />
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $visit->visited_at->format('d M Y') }}</p>
                                                    <p class="text-xs text-gray-500">{{ $visit->visited_at->format('l') }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                    <x-heroicon-s-building-library class="w-4 h-4 text-green-600" />
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $visit->vendor->name ?? $visit->vendor->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $visit->vendor->address }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize
                                                @if($visit->vendor->type === 'hospital')
                                                    bg-red-100 text-red-800
                                                @elseif($visit->vendor->type === 'clinic')
                                                    bg-blue-100 text-blue-800
                                                @elseif($visit->vendor->type === 'diagnostic')
                                                    bg-purple-100 text-purple-800
                                                @elseif($visit->vendor->type === 'pharmacy')
                                                    bg-green-100 text-green-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                                {{ $visit->vendor->type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <p class="font-medium text-gray-900">₹{{ number_format($visit->original_amount ?? 0, 0) }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-green-50 text-green-700 font-semibold">
                                                {{ $visit->discount_percentage }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <p class="text-lg font-bold text-green-600">₹{{ number_format($visit->discount_amount, 0) }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($visits->hasPages())
                    <div class="mt-8 animate-slide-in-up" style="animation-delay: 0.3s;">
                        {{ $visits->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center animate-slide-in-up">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-heroicon-s-inbox class="w-10 h-10 text-gray-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">No Visits Yet</h2>
                    <p class="text-gray-600 mb-6">Your visit history will appear here once you visit any of our partner healthcare providers.</p>
                    <a href="{{ route('patient.vendors.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth">
                        <x-heroicon-s-map-pin class="w-5 h-5" />
                        Find Partner Providers
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>

