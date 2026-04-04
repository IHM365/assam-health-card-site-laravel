@extends('vendor.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Payment History</h1>
            <p class="text-gray-600 mt-2">Track all discounts given and payments</p>
        </div>

        <!-- Date Filter -->
        <form method="GET" action="{{ route('vendor.payments.history') }}" class="flex gap-3">
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                Filter
            </button>
            @if(request('from_date') || request('to_date'))
                <a href="{{ route('vendor.payments.history') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Quick Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border-2 border-red-100 p-4 hover:shadow-lg transition">
            <p class="text-xs font-semibold text-gray-600 uppercase">You Owe Admin</p>
            <p class="text-2xl font-bold text-red-600 mt-2">₹{{ number_format($stats['admin_payment_owed'], 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">3% of total income</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-blue-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Total Income</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">₹{{ number_format($stats['all_time_income'], 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">All time</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-green-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Period Payment</p>
            <p class="text-2xl font-bold text-green-600 mt-2">₹{{ number_format($stats['period_admin_payment'], 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">This period (3%)</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-purple-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Patients Served</p>
            <p class="text-2xl font-bold text-purple-600 mt-2">{{ $stats['total_visits_all_time'] }}</p>
            <p class="text-xs text-gray-500 mt-1">All time visits</p>
        </div>
    </div>

    <!-- Monthly Summary -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Monthly Summary - {{ now()->format('Y') }}</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Month</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Visits</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Discount Given</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Avg Discount</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Total Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($monthlySummary as $month)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $month['month_name'] }}</td>
                            <td class="px-4 py-3 text-center text-sm font-semibold text-gray-900">{{ $month['visits_count'] }}</td>
                            <td class="px-4 py-3 text-right text-sm font-semibold text-green-600">₹{{ number_format($month['total_discount'], 0) }}</td>
                            <td class="px-4 py-3 text-right text-sm text-gray-700">{{ $month['visits_count'] > 0 ? number_format($month['total_discount'] / $month['visits_count'], 0) : '-' }}₹</td>
                            <td class="px-4 py-3 text-right text-sm text-gray-900">₹{{ number_format($month['total_amount'], 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No data available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Visits Ledger -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Payment Ledger</h3>
            <p class="text-sm text-gray-600">{{ $visits->total() }} transactions</p>
        </div>

        @if($visits->count() > 0)
            <div class="overflow-x-auto mb-6">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Service</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Original</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Discount %</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Discount ₹</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Final Amount</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Method</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($visits as $visit)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $visit->visited_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900" title="{{ $visit->patient->user->phone }}">{{ Str::limit($visit->patient->user->name, 15) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ Str::limit($visit->service_type ?? '-', 12) }}</td>
                                <td class="px-4 py-3 text-sm text-right font-semibold text-gray-900">₹{{ number_format($visit->original_amount, 0) }}</td>
                                <td class="px-4 py-3 text-sm text-right text-gray-700">{{ $visit->discount_percentage ?? 0 }}%</td>
                                <td class="px-4 py-3 text-sm text-right font-bold text-green-600">₹{{ number_format($visit->discount_amount, 0) }}</td>
                                <td class="px-4 py-3 text-sm text-right font-bold text-blue-600">₹{{ number_format($visit->original_amount - $visit->discount_amount, 0) }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                        @if($visit->verification_method === 'qr') bg-blue-100 text-blue-800
                                        @elseif($visit->verification_method === 'mobile') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800 @endif
                                    ">
                                        @if($visit->verification_method === 'qr') 
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 11-2 0V5H5v2a1 1 0 11-2 0V4z"></path></svg>QR
                                        @elseif($visit->verification_method === 'mobile') 
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.766.68 1.553.973 2.348.284.797.561 1.6.78 2.396l1.559.779a1 1 0 01.54 1.06l-.74 4.435a1 1 0 01-.986.836H3a1 1 0 01-1-1V3z"></path></svg>Mobile
                                        @else 
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path></svg>Bill 
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Showing <span class="font-semibold">{{ $visits->firstItem() }}</span> to <span class="font-semibold">{{ $visits->lastItem() }}</span> of <span class="font-semibold">{{ $visits->total() }}</span> results
                </div>
                <div>
                    {{ $visits->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 text-lg">No payment records found</p>
                <p class="text-gray-400 text-sm">Start recording visits to see payment history</p>
            </div>
        @endif
    </div>
</div>
@endsection
