<x-layouts.app title="Healthcare Partners | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Healthcare Partners</h1>
                        <p class="text-gray-600 mt-2">Find and explore our network of hospitals, clinics, and diagnostic centers</p>
                    </div>
                    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8 animate-slide-in-up" style="animation-delay: 0.1s;">
                <form method="GET" action="{{ route('patient.vendors.index') }}" class="space-y-4" x-data="{ searchGoing: false }">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Provider</label>
                            <div class="relative">
                                <x-heroicon-s-magnifying-glass class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" />
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Hospital name, clinic, or location..."
                                    class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                        </div>

                        <!-- Type Filter -->
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Provider Type</label>
                            <select name="type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Types</option>
                                <option value="hospital" {{ request('type') === 'hospital' ? 'selected' : '' }}>Hospital</option>
                                <option value="clinic" {{ request('type') === 'clinic' ? 'selected' : '' }}>Clinic</option>
                                <option value="diagnostic" {{ request('type') === 'diagnostic' ? 'selected' : '' }}>Diagnostic Center</option>
                                <option value="pharmacy" {{ request('type') === 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                                <option value="lab" {{ request('type') === 'lab' ? 'selected' : '' }}>Laboratory</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="md:col-span-3 flex items-end">
                            <button
                                type="submit"
                                class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2"
                            >
                                <x-heroicon-s-funnel class="w-5 h-5" />
                                Search
                            </button>
                        </div>
                    </div>

                    @if(request('search') || request('type'))
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-600">
                                Found <span class="font-semibold">{{ $vendors->count() }}</span> partner(s)
                            </div>
                            <a href="{{ route('patient.vendors.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            @if($vendors->count() > 0)
                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 animate-slide-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white rounded-lg border border-blue-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-building-library class="w-5 h-5 text-blue-600" />
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Total Partners</p>
                                <p class="text-xl font-bold text-blue-600">{{ $vendors->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-green-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-percent-badge class="w-5 h-5 text-green-600" />
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Avg Discount</p>
                                <p class="text-xl font-bold text-green-600">{{ number_format($vendors->avg('discount_percentage'), 1) }}%</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-purple-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-check-circle class="w-5 h-5 text-purple-600" />
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Approved</p>
                                <p class="text-xl font-bold text-purple-600">{{ $vendors->where('status', 'approved')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg border border-orange-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-star class="w-5 h-5 text-orange-600" />
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Premium</p>
                                <p class="text-xl font-bold text-orange-600">{{ $vendors->where('discount_percentage', '>=', 20)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vendors Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-slide-in-up" style="animation-delay: 0.3s;">
                    @foreach($vendors as $vendor)
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg hover:border-blue-300 transition-smooth overflow-hidden group">
                            <!-- Card Header with Type Badge -->
                            <div class="relative h-32 bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center overflow-hidden">
                                <!-- Background Icon -->
                                <x-heroicon-s-building-library class="w-24 h-24 text-white opacity-20 absolute" />

                                <!-- Type Badge -->
                                <span class="absolute top-4 right-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize
                                    @if($vendor->type === 'hospital')
                                        bg-red-100 text-red-800
                                    @elseif($vendor->type === 'clinic')
                                        bg-blue-100 text-blue-800
                                    @elseif($vendor->type === 'diagnostic')
                                        bg-purple-100 text-purple-800
                                    @elseif($vendor->type === 'pharmacy')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-gray-100 text-gray-800
                                    @endif
                                ">
                                    {{ $vendor->type }}
                                </span>

                                <!-- Approval Badge -->
                                @if($vendor->status === 'approved')
                                    <span class="absolute bottom-4 right-4 inline-flex items-center gap-1 px-2 py-1 bg-green-500 text-white rounded-full text-xs font-semibold">
                                        <x-heroicon-s-check class="w-3 h-3" />
                                        Verified
                                    </span>
                                @endif
                            </div>

                            <!-- Vendor Info -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-smooth">{{ $vendor->name }}</h3>
                                
                                <!-- Location -->
                                <div class="flex items-start gap-2 mt-3 text-sm text-gray-600">
                                    <x-heroicon-s-map-pin class="w-4 h-4 text-gray-400 flex-shrink-0 mt-1" />
                                    <p class="line-clamp-2">{{ $vendor->address }}</p>
                                </div>

                                <!-- Discount Badge -->
                                <div class="mt-4 inline-flex items-center gap-2 px-3 py-2 bg-green-50 rounded-lg border border-green-200">
                                    <x-heroicon-s-percent-badge class="w-4 h-4 text-green-600" />
                                    <span class="font-bold text-green-700">{{ $vendor->discount_percentage }}% Discount</span>
                                </div>

                                <!-- Contact Info (if needed) -->
                                <div class="mt-6 pt-6 border-t border-gray-200 space-y-2">
                                    <button class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2">
                                        <x-heroicon-s-phone class="w-5 h-5" />
                                        Contact Provider
                                    </button>
                                    <button class="w-full px-4 py-2.5 bg-gray-100 text-gray-800 rounded-lg font-semibold hover:bg-gray-200 transition-smooth flex items-center justify-center gap-2">
                                        <x-heroicon-s-map-pin class="w-5 h-5" />
                                        View Location
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($vendors->hasPages())
                    <div class="mt-12 animate-slide-in-up" style="animation-delay: 0.4s;">
                        {{ $vendors->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border-2 border-dashed border-gray-300 p-12 text-center animate-slide-in-up">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <x-heroicon-s-building-library class="w-10 h-10 text-gray-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">No Partners Found</h2>
                    <p class="text-gray-600 mb-6">We couldn't find any healthcare partners matching your search criteria.</p>
                    <a href="{{ route('patient.vendors.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth">
                        <x-heroicon-s-arrow-path class="w-5 h-5" />
                        View All Partners
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>