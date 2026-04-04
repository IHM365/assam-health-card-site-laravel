@extends('vendor.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Monthly Reports</h1>
            <p class="text-gray-600 mt-2">Detailed analysis of visits and discounts</p>
        </div>

        <!-- Month/Year Selector -->
        <form method="GET" action="{{ route('vendor.reports.monthly') }}" class="flex gap-3">
            <select name="month" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" @selected($m == $month)>{{ Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}</option>
                @endfor
            </select>
            <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" @selected($y == $year)>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                View Report
            </button>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-xl border-2 border-blue-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Total Visits</p>
            <p class="text-2xl font-bold text-blue-600 mt-2">{{ $stats['total_visits'] }}</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-green-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Total Amount</p>
            <p class="text-2xl font-bold text-green-600 mt-2">₹{{ number_format($stats['total_amount'], 0) }}</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-purple-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Total Discount</p>
            <p class="text-2xl font-bold text-purple-600 mt-2">₹{{ number_format($stats['total_discount'], 0) }}</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-orange-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Avg Discount</p>
            <p class="text-2xl font-bold text-orange-600 mt-2">{{ number_format($stats['average_discount'], 1) }}%</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-indigo-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">QR Scans</p>
            <p class="text-2xl font-bold text-indigo-600 mt-2">{{ $stats['qr_scans'] }}</p>
        </div>

        <div class="bg-white rounded-xl border-2 border-pink-100 p-4">
            <p class="text-xs font-semibold text-gray-600 uppercase">Bill Uploads</p>
            <p class="text-2xl font-bold text-pink-600 mt-2">{{ $stats['bill_uploads'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Trend Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Last 12 Months Trend</h3>
            <div class="flex items-end justify-around h-64 gap-1">
                @php
                    $values = array_column($chartData, 'value');
                    $maxValue = (count($values) > 0 ? max($values) : 0);
                    $maxValue = $maxValue > 0 ? $maxValue : 1;
                @endphp
                @foreach($chartData as $data)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-gradient-to-t from-blue-500 to-blue-400 rounded-t" style="height: {{ max(5, (($data['value'] / $maxValue) * 100)) }}%"></div>
                        <p class="text-xs font-semibold text-gray-600 mt-2">{{ $data['month'] }}</p>
                        <p class="text-xs text-gray-500">₹{{ number_format($data['value'], 0) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Services -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Top Services</h3>
            <div class="space-y-4">
                @forelse($topServices as $index => $service)
                    <div class="flex items-between justify-between pb-4 border-b border-gray-100">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold">{{ $index + 1 }}</span>
                                <p class="font-semibold text-gray-900">{{ $service['service'] }}</p>
                            </div>
                            <p class="text-sm text-gray-600">{{ $service['count'] }} visits</p>
                        </div>
                        <p class="font-bold text-gray-900">₹{{ number_format($service['amount'], 0) }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No services recorded yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Verification Methods Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">QR Code Scans</h3>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 11-2 0V5H5v2a1 1 0 11-2 0V4z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['qr_scans'] }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ number_format(($stats['qr_scans'] / max(1, $stats['total_visits'])) * 100, 1) }}% of visits</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Mobile Number</h3>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.766.68 1.553.973 2.348.284.797.561 1.6.78 2.396l1.559.779a1 1 0 01.54 1.06l-.74 4.435a1 1 0 01-.986.836H3a1 1 0 01-1-1V3z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-green-600">{{ $stats['mobile_scans'] }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ number_format(($stats['mobile_scans'] / max(1, $stats['total_visits'])) * 100, 1) }}% of visits</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Bill Upload</h3>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-purple-600">{{ $stats['bill_uploads'] }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ number_format(($stats['bill_uploads'] / max(1, $stats['total_visits'])) * 100, 1) }}% of visits</p>
        </div>
    </div>

    <!-- Detailed Transactions -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mt-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Transactions for {{ $startDate->format('F Y') }}</h3>
        
        @if($monthlyVisits->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Patient</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Service</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Amount</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Discount</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Method</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($monthlyVisits as $visit)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $visit->visited_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $visit->patient->user->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $visit->service_type ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-right font-semibold text-gray-900">₹{{ number_format($visit->original_amount, 0) }}</td>
                                <td class="px-4 py-3 text-sm text-right text-green-600 font-semibold">₹{{ number_format($visit->discount_amount, 0) }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                        @if($visit->verification_method === 'qr') bg-blue-100 text-blue-800
                                        @elseif($visit->verification_method === 'mobile') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800 @endif
                                    ">
                                        @if($visit->verification_method === 'qr') QR
                                        @elseif($visit->verification_method === 'mobile') Mobile
                                        @else Bill @endif
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-500 py-8">No visits recorded for {{ $startDate->format('F Y') }}</p>
        @endif
    </div>
</div>
@endsection
