<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Agent Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-500">Your Patients</div>
                    <div class="mt-2 text-3xl font-semibold text-gray-900">{{ $patientsCount ?? 0 }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <div class="text-sm text-gray-500">Quick Action</div>
                    <div class="mt-3">
                        <a href="{{ route('agent.patients.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Register Patient
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

