<x-layouts.app title="Vendor Details | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center gap-3 mb-4">
                    <a href="{{ route('admin.vendors.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back to Vendors
                    </a>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Vendor Details</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in">
                <!-- Vendor Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <!-- Header Background -->
                        <div class="h-32 bg-gradient-to-r from-blue-500 to-green-500"></div>

                        <!-- Vendor Info -->
                        <div class="px-6 py-6 -mt-16 relative">
                            <!-- Avatar -->
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-green-400 flex items-center justify-center mb-4 border-4 border-white shadow-lg">
                                <x-heroicon-s-building-storefront class="w-12 h-12 text-white" />
                            </div>

                            <!-- Vendor Name -->
                            <h2 class="text-2xl font-bold text-gray-900">{{ $vendor->name }}</h2>
                            
                            <!-- Status Badge -->
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                ];
                                $statusColor = $statusColors[$vendor->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <div class="mt-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                    {{ ucfirst($vendor->status) }}
                                </span>
                            </div>

                            <!-- Info Grid -->
                            <div class="space-y-4 mt-6 pt-6 border-t border-gray-200">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</p>
                                    <p class="text-sm text-gray-700 mt-1 font-semibold">{{ ucfirst($vendor->type) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Discount</p>
                                    <p class="text-lg text-green-600 mt-1 font-bold">{{ $vendor->discount_percentage }}%</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</p>
                                    <p class="text-sm text-gray-700 mt-1 break-all">{{ $vendor->user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</p>
                                    <p class="text-sm text-gray-700 mt-1">{{ $vendor->user->phone }}</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2 mt-6 pt-6 border-t border-gray-200">
                                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2">
                                    <x-heroicon-s-pencil-square class="w-4 h-4" />
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.vendors.destroy', $vendor) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this vendor?');">
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

                <!-- Right Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Address Section -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
                            <x-heroicon-s-map-pin class="w-5 h-5 text-blue-600" />
                            Address
                        </h3>
                        <p class="text-gray-700 leading-relaxed">{{ $vendor->address }}</p>
                    </div>

                    <!-- Recent Visits -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <x-heroicon-s-clipboard class="w-5 h-5 text-green-600" />
                                Recent Visits ({{ $vendor->visits()->count() }})
                            </h3>
                        </div>

                        @if($visits->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Patient</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Card ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Discount</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($visits as $visit)
                                            <tr class="hover:bg-gray-50 transition-smooth">
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    {{ $visit->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <p class="text-sm font-semibold text-gray-900">{{ $visit->patient->user->name }}</p>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <p class="text-sm text-gray-700 font-mono">{{ $visit->patient->id }}</p>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-green-600 font-semibold">
                                                    {{ number_format($visit->discount_amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                    ₹{{ number_format($visit->amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $visits->links() }}
                            </div>
                        @else
                            <div class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                    <x-heroicon-s-document-text class="w-8 h-8 text-gray-400" />
                                </div>
                                <p class="text-gray-600 font-medium">No visits recorded</p>
                                <p class="text-sm text-gray-500">This vendor hasn't had any patient visits yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
