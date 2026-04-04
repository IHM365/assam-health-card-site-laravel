<x-layouts.app title="Patient Management | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Patient Management</h1>
                        <p class="text-gray-600 mt-2">View and manage patient records</p>
                    </div>
                    <a href="{{ route('admin.patients.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth">
                        <x-heroicon-s-user-plus class="w-5 h-5" />
                        Register Patient
                    </a>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8 animate-slide-in-up" style="animation-delay: 0.1s;">
                <form method="GET" action="{{ route('admin.patients.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-8">
                            <div class="relative">
                                <x-heroicon-s-magnifying-glass class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" />
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by name or Card ID..."
                                    class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="md:col-span-2">
                            <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2">
                                <x-heroicon-s-funnel class="w-5 h-5" />
                                Filter
                            </button>
                        </div>
                    </div>

                    @if(request('search') || request('status'))
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-600">
                                Found <span class="font-semibold">{{ $patients->total() }}</span> patient(s)
                            </div>
                            <a href="{{ route('admin.patients.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Patients Table -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-slide-in-up" style="animation-delay: 0.2s;">
                @if($patients->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Card Type</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Card ID</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Phone</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Agent</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                    <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($patients as $patient)
                                    <tr class="hover:bg-gray-50 transition-smooth">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($patient->profile_image && file_exists(public_path($patient->profile_image)))
                                                    <img src="{{ asset($patient->profile_image) }}" alt="{{ $patient->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-300">
                                                @else
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                        <x-heroicon-s-user class="w-5 h-5 text-blue-600" />
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $patient->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $patient->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($patient->card_type === 'family')
                                                @if($patient->isPrimaryMember())
                                                    <div class="flex flex-col gap-1">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800 w-fit">
                                                            <span class="w-2 h-2 bg-purple-600 rounded-full mr-2"></span>
                                                            Family
                                                        </span>
                                                        <span class="text-xs text-gray-600 font-mono">{{ $patient->familyMembers()->count() + 1 }} members</span>
                                                    </div>
                                                @else
                                                    <div class="flex flex-col gap-1">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 w-fit">
                                                            <span class="w-2 h-2 bg-indigo-600 rounded-full mr-2"></span>
                                                            Family Member
                                                        </span>
                                                        <span class="text-xs text-gray-600">{{ $patient->primaryMember()?->name ?? 'N/A' }}</span>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                    <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                                                    Individual
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-mono text-sm font-semibold text-gray-900">AHC-2026-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-700">{{ $patient->phone }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-gray-700">
                                                @if($patient->agent)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                        {{ $patient->agent->user->name }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-500">—</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($patient->status === 'active')
                                                <button 
                                                    onclick="togglePatientStatus(event, {{ $patient->id }}, '{{ route('admin.patients.status', $patient) }}')"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 hover:bg-green-200 transition-smooth cursor-pointer"
                                                    title="Click to deactivate"
                                                >
                                                    <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                                    Active
                                                </button>
                                            @else
                                                <button 
                                                    onclick="togglePatientStatus(event, {{ $patient->id }}, '{{ route('admin.patients.status', $patient) }}')"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 hover:bg-gray-200 transition-smooth cursor-pointer"
                                                    title="Click to activate"
                                                >
                                                    <span class="w-2 h-2 bg-gray-600 rounded-full mr-2"></span>
                                                    Inactive
                                                </button>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <a href="{{ route('admin.patients.card', $patient) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-smooth" title="Download Card">
                                                    <x-heroicon-s-arrow-down-tray class="w-5 h-5" />
                                                </a>
                                                <a href="{{ route('admin.patients.acknowledgement', $patient) }}" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-smooth" title="Download Acknowledgement">
                                                    <x-heroicon-s-document class="w-5 h-5" />
                                                </a>
                                                <a href="{{ route('admin.patients.show', $patient) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-smooth" title="View">
                                                    <x-heroicon-s-eye class="w-5 h-5" />
                                                </a>
                                                <a href="{{ route('admin.patients.edit', $patient) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-smooth" title="Edit">
                                                    <x-heroicon-s-pencil-square class="w-5 h-5" />
                                                </a>
                                                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-smooth" title="Delete">
                                                        <x-heroicon-s-trash class="w-5 h-5" />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($patients->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $patients->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-heroicon-s-user-group class="w-8 h-8 text-gray-400" />
                        </div>
                        <p class="text-gray-600 font-medium">No patients found</p>
                        <p class="text-sm text-gray-500 mt-1">Get started by registering a new patient</p>
                        <a href="{{ route('admin.patients.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth mt-4">
                            <x-heroicon-s-user-plus class="w-5 h-5" />
                            Register Patient
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script type="module">
        import { showSuccess, showError, showConfirm } from '{{ asset('resources/js/sweetalert-utils.js') }}';

        window.togglePatientStatus = async function(event, patientId, actionUrl) {
            event.preventDefault();

            const result = await showConfirm(
                'Change Status?',
                'Are you sure you want to change this patient\'s status?',
                'Yes, Change',
                'Cancel'
            );

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(actionUrl, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                const data = await response.json();

                if (data.success) {
                    await showSuccess('Success', data.message);
                    // Reload the table or update the row
                    setTimeout(() => location.reload(), 1500);
                } else {
                    await showError('Error', data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                await showError('Error', 'Failed to update status');
            }
        };
    </script>
</x-layouts.app>
