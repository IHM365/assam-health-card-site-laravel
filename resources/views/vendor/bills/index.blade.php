@extends('vendor.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Upload Patient Bill</h1>
        <p class="text-gray-600 mt-2">Record patient visits and generate automatic discount</p>
    </div>

    <!-- Statistics Cards -->
    @if(isset($stats))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl border-2 border-blue-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Bills</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_bills'] }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 11-2 0V5H5v2a1 1 0 11-2 0V4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border-2 border-green-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Original Amount</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">₹{{ number_format($stats['total_amount'], 0) }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.16 2.75a.75.75 0 00-.75.75v18.5c0 .414.336.75.75.75h3.68a.75.75 0 00.75-.75V3.5a.75.75 0 00-.75-.75H8.16z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border-2 border-purple-100 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Discount Given</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">₹{{ number_format($stats['total_discount'], 0) }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v14a1 1 0 01-1 1H6a1 1 0 01-1-1V2zm3 4a1 1 0 100-2 1 1 0 000 2zm0 4a1 1 0 100-2 1 1 0 000 2zm0 4a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Upload Form -->
    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
            </svg>
            Record Patient Visit
        </h2>

        <form action="{{ route('vendor.bills.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Patient Phone -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-3">
                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.766.68 1.553.973 2.348.284.797.561 1.6.78 2.396l1.559.779a1 1 0 01.54 1.06l-.74 4.435a1 1 0 01-.986.836H3a1 1 0 01-1-1V3z"></path>
                    </svg>
                    Patient Mobile Number *
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-600 font-semibold">+91</span>
                    <input
                        type="tel"
                        name="patient_phone"
                        placeholder="Enter 10-digit number"
                        pattern="[0-9]{10}"
                        inputmode="numeric"
                        required
                        value="{{ old('patient_phone') }}"
                        class="w-full pl-14 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    />
                </div>
                @error('patient_phone')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service Type -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H7a1 1 0 01-1-1v-6z" clip-rule="evenodd"></path>
                        </svg>
                        Service Type *
                    </label>
                    <input
                        type="text"
                        name="service_type"
                        placeholder="e.g., Consultation, Blood Test, X-Ray"
                        required
                        value="{{ old('service_type') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    />
                    @error('service_type')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Original Amount -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">
                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                        </svg>
                        Original Amount *
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-600 font-semibold">₹</span>
                        <input
                            type="number"
                            name="original_amount"
                            placeholder="Amount in rupees"
                            step="0.01"
                            min="0"
                            required
                            value="{{ old('original_amount') }}"
                            class="w-full pl-8 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        />
                    </div>
                    @error('original_amount')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-3">
                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.5 1A1.5 1.5 0 001 2.5v15A1.5 1.5 0 002.5 19h15a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0017.5 1h-15z"></path>
                    </svg>
                    Notes (Optional)
                </label>
                <textarea
                    name="notes"
                    placeholder="Add any additional notes..."
                    rows="3"
                    value="{{ old('notes') }}"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                ></textarea>
                @error('notes')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bill File Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-3">
                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                    </svg>
                    Attach Bill (PDF/Image - Optional)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition bg-gray-50">
                    <input
                        type="file"
                        name="bill_file"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="hidden"
                        id="bill-file-input"
                    />
                    <label for="bill-file-input" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-12l-3.172-3.172a4 4 0 00-5.656 0L28 20M9 20l3.172-3.172a4 4 0 015.656 0L28 20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="text-gray-600 font-medium mt-2">
                            <span id="file-name">Drag and drop your bill here, or click to select</span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG up to 5MB</p>
                    </label>
                </div>
                @error('bill_file')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button
                    type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:shadow-lg transition flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Submit & Record Visit
                </button>
                <a href="{{ route('vendor.visits.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-lg hover:bg-gray-300 transition text-center">
                    View History
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// File upload handling
document.getElementById('bill-file-input').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Drag and drop your bill here, or click to select';
    document.getElementById('file-name').textContent = fileName;
});
</script>
@endsection
