<x-layouts.app title="Agent Details | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center gap-3 mb-4">
                    <a href="{{ route('admin.agents.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back to Agents
                    </a>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Agent Details</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in">
                <!-- Agent Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <!-- Header Background -->
                        <div class="h-32 bg-gradient-to-r from-blue-500 to-green-500"></div>

                        <!-- Agent Info -->
                        <div class="px-6 py-6 -mt-16 relative">
                            <!-- Avatar -->
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-green-400 flex items-center justify-center mb-4 border-4 border-white shadow-lg">
                                <x-heroicon-s-user-group class="w-12 h-12 text-white" />
                            </div>

                            <!-- Agent Name -->
                            <h2 class="text-2xl font-bold text-gray-900">{{ $agent->user->name }}</h2>
                            <p class="text-blue-600 font-semibold mt-1">Healthcare Agent</p>

                            <!-- Info Grid -->
                            <div class="space-y-4 mt-6 pt-6 border-t border-gray-200">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</p>
                                    <p class="text-sm text-gray-700 mt-1 break-all">{{ $agent->user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</p>
                                    <p class="text-sm text-gray-700 mt-1">{{ $agent->user->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Referral Code</p>
                                    <p class="text-sm text-gray-700 mt-1 font-mono font-semibold">{{ $agent->referral_code }}</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 mt-6 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.agents.edit', $agent) }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2">
                                    <x-heroicon-s-pencil-square class="w-4 h-4" />
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.agents.destroy', $agent) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this agent?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-smooth flex items-center justify-center gap-2">
                                        <x-heroicon-s-trash class="w-4 h-4" />
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Patients -->
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <x-heroicon-s-users class="w-5 h-5 text-green-600" />
                            Assigned Patients ({{ $patients->total() }})
                        </h3>
                    </div>

                    @if($patients->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Patient Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Card ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Phone</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($patients as $patient)
                                        <tr class="hover:bg-gray-50 transition-smooth">
                                            <td class="px-6 py-4">
                                                <a href="{{ route('admin.patients.show', $patient) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                                                    {{ $patient->user->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-700 font-mono">{{ $patient->id }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-gray-700">{{ $patient->user->phone }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($patient->status === 'active')
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                        <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $patients->links() }}
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <x-heroicon-s-users class="w-8 h-8 text-gray-400" />
                            </div>
                            <p class="text-gray-600 font-medium">No patients assigned</p>
                            <p class="text-sm text-gray-500">This agent hasn't been assigned any patients yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
