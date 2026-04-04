<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Visit Details
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.visits.edit', $visit) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.586 15H9v-2.586l8.172-8.172z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.visits.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Details -->
            <div class="bg-white shadow-sm rounded-lg p-8 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Visit Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Visit Information</h3>
                        <div class="space-y-4">
                            <div class="border-b pb-4">
                                <p class="text-sm text-gray-600">Visit Date & Time</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $visit->visited_at->format('F d, Y • H:i A') }}</p>
                            </div>
                            <div class="border-b pb-4">
                                <p class="text-sm text-gray-600">Service Type</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $visit->service_type ?? 'Not Specified' }}</p>
                            </div>
                            <div class="border-b pb-4">
                                <p class="text-sm text-gray-600">Verification Method</p>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($visit->verification_method === 'qr')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-800 rounded-full font-semibold">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 3a2 2 0 012-2h6a2 2 0 012 2v2h2a2 2 0 012 2v10a2 2 0 01-2 2H3a2 2 0 01-2-2V7a2 2 0 012-2h2V3z" clip-rule="evenodd"></path>
                                            </svg>
                                            QR Code Scan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.766.68 1.553.973 2.348.284.797.561 1.6.78 2.396l1.559.779a1 1 0 01.54 1.06l-.74 4.435a1 1 0 01-.986.836H3a1 1 0 01-1-1V3z"></path>
                            </svg>
                                            Mobile Number
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Notes</p>
                                <p class="text-gray-900 mt-1">{{ $visit->notes ?? 'No notes' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Financial Details</h3>
                        <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Original Amount</span>
                                <span class="text-lg font-semibold text-gray-900">₹{{ number_format($visit->original_amount, 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between py-4 border-t border-b">
                                <span class="text-gray-600">Discount Percentage</span>
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">
                                    {{ $visit->discount_percentage }}%
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 mb-4">
                                <span class="text-gray-600">Discount Amount</span>
                                <span class="text-lg font-semibold text-green-600">-₹{{ number_format($visit->discount_amount, 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t-2 text-lg">
                                <span class="font-semibold text-gray-900">Final Amount</span>
                                <span class="font-bold text-green-600">₹{{ number_format($visit->original_amount - $visit->discount_amount, 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patient Information -->
            <div class="bg-white shadow-sm rounded-lg p-8 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Patient Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Full Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $visit->patient->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Patient ID</p>
                        <p class="text-lg font-semibold text-gray-900">#{{ $visit->patient_id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Phone</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $visit->patient->user->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $visit->patient->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Card Type</p>
                        <p class="text-lg font-semibold text-gray-900 capitalize">{{ $visit->patient->card_type }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status</p>
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">
                            {{ ucfirst($visit->patient->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Vendor Information -->
            <div class="bg-white shadow-sm rounded-lg p-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Healthcare Provider Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Provider Name</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $visit->vendor->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Type</p>
                        <p class="text-lg font-semibold text-gray-900 capitalize">{{ $visit->vendor->type }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Address</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $visit->vendor->address }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Phone</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $visit->vendor->user->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Discount Rate</p>
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">
                            {{ $visit->vendor->discount_percentage }}%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status</p>
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold">
                            {{ ucfirst($visit->vendor->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
