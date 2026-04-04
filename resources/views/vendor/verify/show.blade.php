<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verification
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm text-gray-500">Patient</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->name }}</div>
                        <div class="text-sm text-gray-700">ID: {{ $patient->id }}</div>
                        <div class="text-sm text-gray-700">Phone: {{ $patient->phone }}</div>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                Status: {{ ucfirst($patient->status) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Vendor Discount</div>
                        <div class="mt-1 text-4xl font-semibold text-gray-900">{{ $vendor->discount_percentage }}%</div>
                        <div class="text-sm text-gray-600">Vendor status: {{ ucfirst($vendor->status) }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900">Mark Visit</h3>
                <form method="POST" action="{{ route('vendor.visits.store') }}" class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    <div class="sm:col-span-2">
                        <x-input-label for="original_amount" value="Original Amount (optional)" />
                        <x-text-input id="original_amount" name="original_amount" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('original_amount')" />
                        <x-input-error class="mt-2" :messages="$errors->get('original_amount')" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Mark Visit</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

