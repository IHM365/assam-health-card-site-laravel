@extends('vendor.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Visit History</h1>
            <p class="text-gray-600 mt-2">Track all your transactions and discount records</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded-full">
                <span class="font-semibold">Total Visits: {{ $visits->total() }}</span>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-blue-500">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4" id="filterForm">
            <!-- Date From -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <!-- Date To -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <!-- Patient Search -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Patient Name</label>
                <input type="text" name="patient_name" placeholder="Search patient..." value="{{ request('patient_name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <!-- Amount Range -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Amount Range</label>
                <select name="amount_range" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">All Amounts</option>
                    <option value="0-500" {{ request('amount_range') === '0-500' ? 'selected' : '' }}>₹0 - ₹500</option>
                    <option value="500-1000" {{ request('amount_range') === '500-1000' ? 'selected' : '' }}>₹500 - ₹1000</option>
                    <option value="1000-5000" {{ request('amount_range') === '1000-5000' ? 'selected' : '' }}>₹1000 - ₹5000</option>
                    <option value="5000+" {{ request('amount_range') === '5000+' ? 'selected' : '' }}>₹5000+</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 items-end">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                    Filter
                </button>
                <a href="{{ route('vendor.visits.index') }}" class="flex-1 px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg hover:bg-gray-500 transition text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    @if ($visits->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Total Visits -->
        <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-semibold">Total Visits This Period</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_visits'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Discount Given -->
        <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-semibold">Total Discount Given</p>
                    <p class="text-3xl font-bold mt-2">₹{{ number_format($stats['total_discount'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Amount Received -->
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-semibold">Total Amount Received</p>
                    <p class="text-3xl font-bold mt-2">₹{{ number_format($stats['total_received'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.16 2.75a.75.75 0 00-.75.75v.001a.75.75 0 00.75.75H9v.001a3 3 0 013 3v1h2.25a.75.75 0 000 1.5H12v1h2.25a.75.75 0 000 1.5H12v1a3 3 0 01-3 3v.001h-.84a.75.75 0 000 1.5h.84a.75.75 0 00.75-.75v-.001a.75.75 0 00-.75-.75H11v-.001a3 3 0 01-3-3v-1H5.75a.75.75 0 000-1.5H8v-1H5.75a.75.75 0 000-1.5H8v-1a3 3 0 013-3v-.001h.84a.75.75 0 00.75-.75V3.5a.75.75 0 00-.75-.75H8.16z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Average Discount -->
        <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-semibold">Average Discount</p>
                    <p class="text-3xl font-bold mt-2">₹{{ number_format($stats['avg_discount'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Visits Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-blue-500">
        @if ($visits->count())
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50 to-emerald-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Date & Time</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Patient Details</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Service Type</th>
                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Method</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Original Amount</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Discount %</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Discount Amt</th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Final Amount</th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">
                        <!-- Date & Time -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">{{ $visit->visited_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $visit->visited_at->format('h:i A') }}</div>
                        </td>

                        <!-- Patient Details -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if ($visit->patient->profile_image)
                                <img src="{{ Storage::url($visit->patient->profile_image) }}" alt="{{ $visit->patient->user->name }}" 
                                     class="w-10 h-10 rounded-full mr-3 object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full mr-3 bg-gradient-to-r from-blue-400 to-emerald-400 flex items-center justify-center text-white font-bold">
                                    {{ substr($visit->patient->user->name, 0, 1) }}
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">{{ $visit->patient->user->name }}</div>
                                    <div class="text-xs text-gray-500">#{{ $visit->patient->id }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Service Type -->
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">
                                {{ $visit->service_type ?? 'General Service' }}
                            </span>
                        </td>

                        <!-- Verification Method -->
                        <td class="px-6 py-4">
                            @if ($visit->verification_method === 'qr')
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 11-2 0V5H5v2a1 1 0 11-2 0V4z"></path>
                                    </svg>
                                    QR Scan
                                </span>
                            @elseif ($visit->verification_method === 'mobile')
                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.766.68 1.553.973 2.348.284.797.561 1.6.78 2.396l1.559.779a1 1 0 01.54 1.06l-.74 4.435a1 1 0 01-.986.836H3a1 1 0 01-1-1V3z"></path>
                                    </svg>
                                    Mobile
                                </span>
                            @elseif ($visit->verification_method === 'bill')
                                <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                    </svg>
                                    Bill
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">
                                    Unknown
                                </span>
                            @endif
                        </td>

                        <!-- Original Amount -->
                        <td class="px-6 py-4 text-right">
                            <div class="text-sm font-semibold text-gray-800">₹{{ number_format($visit->original_amount, 2) }}</div>
                        </td>

                        <!-- Discount % -->
                        <td class="px-6 py-4 text-right">
                            <div class="text-sm font-bold text-blue-600">{{ $visit->discount_percentage }}%</div>
                        </td>

                        <!-- Discount Amount -->
                        <td class="px-6 py-4 text-right">
                            <div class="text-sm font-bold text-green-600">₹{{ number_format($visit->discount_amount, 2) }}</div>
                        </td>

                        <!-- Final Amount -->
                        <td class="px-6 py-4 text-right">
                            <div class="text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg inline-block">
                                ₹{{ number_format($visit->original_amount - $visit->discount_amount, 2) }}
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- View Receipt -->
                                <a href="{{ route('vendor.scan.receipt', $visit->id) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-xs font-semibold"
                                   title="Download Receipt">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Receipt
                                </a>

                                <!-- View Details -->
                                <button onclick="viewDetails({{ $visit->id }}, '{{ $visit->patient->user->name }}', {{ $visit->original_amount }}, {{ $visit->discount_percentage }}, {{ $visit->discount_amount }})"
                                        class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-xs font-semibold"
                                        title="View Details">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $visits->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-12 px-6">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Visit Records Found</h3>
            <p class="text-gray-600 text-center mb-6">Start scanning cards to create and track visit records</p>
            <a href="{{ route('vendor.scan.index') }}" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                Go to Scan Card
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
        <div class="bg-gradient-to-r from-blue-500 to-emerald-500 p-6 text-white">
            <h2 class="text-2xl font-bold">Visit Details</h2>
        </div>
        <div class="p-6 space-y-4" id="detailsContent">
            <!-- Populated by JavaScript -->
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-450 text-gray-800 font-semibold rounded-lg hover:bg-gray-500 transition">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function viewDetails(visitId, patientName, originalAmount, discountPercentage, discountAmount) {
    const finalAmount = originalAmount - discountAmount;
    const content = `
        <div class="space-y-3">
            <div class="p-3 bg-gray-50 rounded">
                <p class="text-xs text-gray-600">Patient Name</p>
                <p class="text-lg font-bold text-gray-800">${patientName}</p>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3 bg-gray-50 rounded">
                    <p class="text-xs text-gray-600">Original Amount</p>
                    <p class="text-lg font-bold text-gray-800">₹${parseFloat(originalAmount).toFixed(2)}</p>
                </div>
                <div class="p-3 bg-gray-50 rounded">
                    <p class="text-xs text-gray-600">Discount %</p>
                    <p class="text-lg font-bold text-blue-600">${discountPercentage}%</p>
                </div>
            </div>
            <div class="p-3 bg-green-50 rounded border-2 border-green-200">
                <p class="text-xs text-gray-600">Discount Amount</p>
                <p class="text-lg font-bold text-green-600">₹${parseFloat(discountAmount).toFixed(2)}</p>
            </div>
            <div class="p-3 bg-emerald-50 rounded border-2 border-emerald-300">
                <p class="text-xs text-gray-600">Final Amount (Patient Pays)</p>
                <p class="text-2xl font-bold text-emerald-600">₹${parseFloat(finalAmount).toFixed(2)}</p>
            </div>
        </div>
    `;
    document.getElementById('detailsContent').innerHTML = content;
    document.getElementById('detailsModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('detailsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('detailsModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
@endsection

