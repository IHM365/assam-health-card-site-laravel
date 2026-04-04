<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verify Patient
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-600">Scan QR (opens verify URL) or enter Patient ID manually.</p>

                <form method="GET" action="{{ route('vendor.verify.show', ['patient' => 0]) }}" class="mt-4 flex gap-3" onsubmit="event.preventDefault(); window.location.href = '{{ url('/vendor/verify') }}/' + document.getElementById('patient_id').value;">
                    <div class="flex-1">
                        <x-text-input id="patient_id" name="patient_id" type="number" min="1" class="block w-full" placeholder="Patient ID" required />
                    </div>
                    <x-primary-button type="submit">Verify</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

