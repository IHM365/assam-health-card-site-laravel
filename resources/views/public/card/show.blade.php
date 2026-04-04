<x-guest-layout>
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex items-start justify-between gap-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Assam Health Card</h1>
                    <div class="mt-4 text-sm text-gray-500">Patient ID</div>
                    <div class="text-2xl font-semibold text-gray-900">{{ $patient->id }}</div>
                    <div class="mt-4 text-sm text-gray-500">Name</div>
                    <div class="text-lg font-medium text-gray-900">{{ $patient->name }}</div>
                    <div class="mt-2 text-sm text-gray-700">Status: {{ ucfirst($patient->status) }}</div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border">
                    {!! QrCode::size(220)->margin(1)->generate($verifyUrl) !!}
                    <div class="mt-3 text-xs text-gray-500 break-all text-center">{{ $verifyUrl }}</div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

