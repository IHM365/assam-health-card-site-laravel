<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Patients
            </h2>
            <a href="{{ route('agent.patients.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Register Patient
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-500">
                                <tr>
                                    <th class="py-2">ID</th>
                                    <th class="py-2">Name</th>
                                    <th class="py-2">Phone</th>
                                    <th class="py-2">Status</th>
                                    <th class="py-2">Card</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($patients as $patient)
                                    <tr>
                                        <td class="py-3 text-gray-700">{{ $patient->id }}</td>
                                        <td class="py-3 font-medium text-gray-900">{{ $patient->name }}</td>
                                        <td class="py-3 text-gray-700">{{ $patient->phone }}</td>
                                        <td class="py-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">
                                                {{ ucfirst($patient->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <a class="text-indigo-600 hover:text-indigo-800" href="{{ route('public.card.show', $patient->id) }}" target="_blank" rel="noreferrer">
                                                View card
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-gray-500">No patients yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

