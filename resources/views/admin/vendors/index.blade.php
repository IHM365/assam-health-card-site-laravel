<x-layouts.app title="Vendors | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Vendors Management</h1>
                        <p class="text-gray-600 mt-2">Manage healthcare partners and their information</p>
                    </div>
                    <a href="{{ route('admin.vendors.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth">
                        <x-heroicon-s-plus class="w-5 h-5" />
                        Add Vendor
                    </a>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-6 animate-slide-in-up">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <div class="relative">
                                <x-heroicon-s-magnifying-glass class="w-5 h-5 absolute left-3 top-3 text-gray-400" />
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by name, email, or phone..."
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                        </div>
                        <select name="type" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- All Types --</option>
                            <option value="hospital" {{ request('type') === 'hospital' ? 'selected' : '' }}>Hospital</option>
                            <option value="clinic" {{ request('type') === 'clinic' ? 'selected' : '' }}>Clinic</option>
                            <option value="diagnostic" {{ request('type') === 'diagnostic' ? 'selected' : '' }}>Diagnostic</option>
                            <option value="pharmacy" {{ request('type') === 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                        </select>
                        <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- All Status --</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center gap-2">
                        <x-heroicon-s-funnel class="w-5 h-5" />
                        Filter
                    </button>
                </form>
            </div>

            <!-- Results Counter -->
            <div class="mb-6 animate-fade-in">
                <p class="text-sm text-gray-600 font-medium">
                    Showing <span class="text-gray-900 font-semibold">{{ $vendors->count() }}</span> of <span class="text-gray-900 font-semibold">{{ $vendors->total() }}</span> vendors
                </p>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden animate-slide-in-up">
                @if($vendors->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Vendor Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Discount</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($vendors as $vendor)
                                    <tr class="hover:bg-gray-50 transition-smooth">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-gray-900">{{ $vendor->name }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-gray-700">{{ $vendor->user->email }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $typeColors = [
                                                    'hospital' => 'bg-red-100 text-red-700',
                                                    'clinic' => 'bg-blue-100 text-blue-700',
                                                    'diagnostic' => 'bg-purple-100 text-purple-700',
                                                    'pharmacy' => 'bg-green-100 text-green-700',
                                                ];
                                                $color = $typeColors[$vendor->type] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                                {{ ucfirst($vendor->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-green-600">{{ $vendor->discount_percentage }}%</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'approved' => 'bg-green-100 text-green-700',
                                                    'rejected' => 'bg-red-100 text-red-700',
                                                ];
                                                $statusColor = $statusColors[$vendor->status] ?? 'bg-gray-100 text-gray-700';
                                            @endphp
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                                {{ ucfirst($vendor->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.vendors.show', $vendor) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-smooth" title="View">
                                                    <x-heroicon-s-eye class="w-4 h-4" />
                                                </a>
                                                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition-smooth" title="Edit">
                                                    <x-heroicon-s-pencil-square class="w-4 h-4" />
                                                </a>
                                                <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this vendor?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-smooth" title="Delete">
                                                        <x-heroicon-s-trash class="w-4 h-4" />
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
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $vendors->links() }}
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <x-heroicon-s-building-storefront class="w-8 h-8 text-gray-400" />
                        </div>
                        <p class="text-gray-600 font-medium">No vendors found</p>
                        <p class="text-sm text-gray-500 mb-6">You haven't added any vendors yet.</p>
                        <a href="{{ route('admin.vendors.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth">
                            <x-heroicon-s-plus class="w-5 h-5" />
                            Add First Vendor
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>

