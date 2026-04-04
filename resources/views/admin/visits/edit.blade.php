<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Visit Record
            </h2>
            <a href="{{ route('admin.visits.show', $visit) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg">
                <form method="POST" action="{{ route('admin.visits.update', $visit) }}" class="p-8 space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Original Amount -->
                    <div>
                        <label for="original_amount" class="block text-sm font-semibold text-gray-900 mb-3">
                            Original Amount *
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-600 font-semibold">₹</span>
                            <input 
                                type="number" 
                                name="original_amount" 
                                id="original_amount"
                                step="0.01"
                                min="0"
                                value="{{ old('original_amount', $visit->original_amount) }}"
                                required
                                class="w-full pl-8 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                onchange="calculateFinal()"
                                oninput="calculateFinal()"
                            />
                        </div>
                        @error('original_amount')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount Percentage -->
                    <div>
                        <label for="discount_percentage" class="block text-sm font-semibold text-gray-900 mb-3">
                            Discount Percentage *
                        </label>
                        <div class="relative">
                            <input 
                                type="number" 
                                name="discount_percentage" 
                                id="discount_percentage"
                                step="0.01"
                                min="0"
                                max="100"
                                value="{{ old('discount_percentage', $visit->discount_percentage) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                onchange="calculateFinal()"
                                oninput="calculateFinal()"
                            />
                            <span class="absolute right-4 top-3 text-gray-600 font-semibold">%</span>
                        </div>
                        @error('discount_percentage')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount Amount (Auto-calculated) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-3">
                            Discount Amount (Auto-calculated)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-600 font-semibold">₹</span>
                            <input 
                                type="number" 
                                id="discount_amount"
                                step="0.01"
                                min="0"
                                value="{{ old('discount_amount', $visit->discount_amount) }}"
                                readonly
                                class="w-full pl-8 px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                            />
                        </div>
                    </div>

                    <!-- Final Amount -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-3">
                            Final Amount
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-600 font-semibold">₹</span>
                            <input 
                                type="number" 
                                id="final_amount"
                                step="0.01"
                                min="0"
                                readonly
                                class="w-full pl-8 px-4 py-3 border border-gray-300 rounded-lg bg-green-50 text-green-700 font-semibold"
                            />
                        </div>
                    </div>

                    <!-- Service Type -->
                    <div>
                        <label for="service_type" class="block text-sm font-semibold text-gray-900 mb-3">
                            Service Type
                        </label>
                        <input 
                            type="text" 
                            name="service_type" 
                            id="service_type"
                            placeholder="e.g., Consultation, Lab Test, Surgery"
                            value="{{ old('service_type', $visit->service_type) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <p class="text-sm text-gray-500 mt-2">Optional: Describe the type of service provided</p>
                        @error('service_type')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-900 mb-3">
                            Notes
                        </label>
                        <textarea 
                            name="notes" 
                            id="notes"
                            rows="4"
                            placeholder="Add any additional notes about this visit..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >{{ old('notes', $visit->notes) }}</textarea>
                        <p class="text-sm text-gray-500 mt-2">Optional: Maximum 1000 characters</p>
                        @error('notes')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visit Information (Read-only) -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Visit Information (Read-only)</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Date & Time</p>
                                <p class="font-semibold text-gray-900">{{ $visit->visited_at->format('F d, Y • H:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Verification Method</p>
                                <p class="font-semibold text-gray-900 capitalize">{{ $visit->verification_method }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Patient</p>
                                <p class="font-semibold text-gray-900">{{ $visit->patient->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Provider</p>
                                <p class="font-semibold text-gray-900">{{ $visit->vendor->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Visit
                        </button>
                        <a href="{{ route('admin.visits.show', $visit) }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 font-semibold transition text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function calculateFinal() {
            const originalAmount = parseFloat(document.getElementById('original_amount').value) || 0;
            const discountPercentage = parseFloat(document.getElementById('discount_percentage').value) || 0;
            
            const discountAmount = (originalAmount * discountPercentage) / 100;
            const finalAmount = originalAmount - discountAmount;
            
            document.getElementById('discount_amount').value = discountAmount.toFixed(2);
            document.getElementById('final_amount').value = finalAmount.toFixed(2);
        }
        
        // Calculate on page load
        document.addEventListener('DOMContentLoaded', calculateFinal);
    </script>
</x-app-layout>
