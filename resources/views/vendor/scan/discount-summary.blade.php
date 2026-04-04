@extends('vendor.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-2xl">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full mb-4 animate-bounce">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Verification Successful</h1>
            <p class="text-lg text-gray-600">Discount calculated and ready to generate receipt</p>
        </div>

        <!-- Patient Information Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6 border-t-4 border-blue-500">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Patient Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Patient Name</p>
                    <p class="text-xl font-bold text-gray-800">{{ $patient->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Patient ID</p>
                    <p class="text-xl font-bold text-gray-800">#{{ $patient->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Card Type</p>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        {{ ucfirst($patient->card_type) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Visit Date</p>
                    <p class="text-xl font-bold text-gray-800">{{ $visit->visited_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Discount Calculation Card -->
        <div class="bg-gradient-to-r from-blue-50 to-emerald-50 rounded-lg shadow-lg p-8 mb-6 border-2 border-blue-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Discount Summary</h2>

            <!-- Calculation Breakdown -->
            <div class="space-y-4 mb-8">
                <!-- Original Amount -->
                <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Original Amount</p>
                            <p class="text-lg font-semibold text-gray-800">Service Cost</p>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">₹{{ number_format($visit->original_amount, 2) }}</p>
                </div>

                <!-- Discount Rate -->
                <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Discount Rate</p>
                            <p class="text-lg font-semibold text-gray-800">Applied Percentage</p>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-blue-600">{{ $visit->discount_percentage }}%</p>
                </div>

                <!-- Discount Amount -->
                <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Discount Amount</p>
                            <p class="text-lg font-semibold text-gray-800">You Save</p>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-green-600">₹{{ number_format($visit->discount_amount, 2) }}</p>
                </div>

                <!-- Final Amount (Divider) -->
                <div class="border-2 border-dashed border-gray-300 my-4"></div>

                <!-- Final Amount -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-100 to-green-100 rounded-lg shadow-md border-2 border-emerald-300">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-200 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12L2 3m7 9l7 8m4-9l2-7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-emerald-900 font-semibold">Final Amount</p>
                            <p class="text-lg font-bold text-emerald-900">Patient Pays</p>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-emerald-600">₹{{ number_format($visit->original_amount - $visit->discount_amount, 2) }}</p>
                </div>
            </div>

            <!-- Visual Breakdown Chart -->
            <div class="mb-8">
                <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide mb-3">Amount Breakdown</p>
                <div class="flex h-12 rounded-lg overflow-hidden shadow">
                    <!-- Discount portion -->
                    <div class="bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold" 
                         style="width: {{ ($visit->discount_amount / $visit->original_amount) * 100 }}%">
                        <span class="text-sm">{{ round(($visit->discount_amount / $visit->original_amount) * 100, 1) }}% Saved</span>
                    </div>
                    <!-- Final amount portion -->
                    <div class="bg-blue-400 flex items-center justify-center text-white font-bold" 
                         style="width: {{ (($visit->original_amount - $visit->discount_amount) / $visit->original_amount) * 100 }}%">
                        <span class="text-sm">{{ round((($visit->original_amount - $visit->discount_amount) / $visit->original_amount) * 100, 1) }}% Payable</span>
                    </div>
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-600">
                    <span>Saved: ₹{{ number_format($visit->discount_amount, 2) }}</span>
                    <span>Payable: ₹{{ number_format($visit->original_amount - $visit->discount_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Download Receipt PDF -->
            <a href="{{ route('vendor.scan.receipt', $visit->id) }}" 
               class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                </svg>
                Download Receipt (PDF)
            </a>

            <!-- Print Receipt -->
            <button onclick="window.print()" 
                    class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Receipt
            </button>

            <!-- New Scan Button -->
            <a href="{{ route('vendor.scan.index') }}" 
               class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Scan
            </a>
        </div>

        <!-- Return to Dashboard -->
        <div class="mt-6 text-center">
            <a href="{{ route('vendor.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition duration-300">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        body {
            background: white;
            padding: 0;
        }
        .no-print {
            display: none;
        }
        .print-only {
            display: block;
        }
        .flex {
            display: flex;
        }
        .justify-between {
            justify-content: space-between;
        }
    }
</style>
@endsection
