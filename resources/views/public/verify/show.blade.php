<x-guest-layout>
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-900">Patient Verification</h1>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
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
                    @if($vendor)
                        <div class="mt-1 text-4xl font-semibold text-gray-900">{{ $vendor->discount_percentage }}%</div>
                        <div class="text-sm text-gray-600">Vendor status: {{ ucfirst($vendor->status) }}</div>
                    @else
                        <div class="mt-2 text-sm text-gray-700">Login as Vendor to see discount and mark visit.</div>
                        <div class="mt-3">
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Vendor Login
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($vendor)
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-base font-semibold text-gray-900">Mark Visit</h2>
                <p class="mt-1 text-sm text-gray-600">This action requires vendor authentication (you are logged in).</p>
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
        @endif
    </div>
</x-guest-layout>

