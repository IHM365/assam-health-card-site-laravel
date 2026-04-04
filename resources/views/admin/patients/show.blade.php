<x-layouts.app title="Patient Details | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center gap-3 mb-4">
                    <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back to Patients
                    </a>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Patient Details</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in">
                <!-- Patient Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <!-- Header Background -->
                        <div class="h-32 bg-gradient-to-r from-blue-500 to-green-500"></div>

                        <!-- Patient Info -->
                        <div class="px-6 py-6 -mt-16 relative">
                            <!-- Avatar -->
                            @if($patient->profile_image && file_exists(public_path($patient->profile_image)))
                                <img src="{{ asset($patient->profile_image) }}" alt="{{ $patient->user->name }}" class="w-24 h-24 rounded-full object-cover mb-4 border-4 border-white shadow-lg">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-green-400 flex items-center justify-center mb-4 border-4 border-white shadow-lg">
                                    <x-heroicon-s-user class="w-12 h-12 text-white" />
                                </div>
                            @endif

                            <!-- Patient Name -->
                            <h2 class="text-2xl font-bold text-gray-900">{{ $patient->user->name }}</h2>
                            <p class="text-green-600 font-semibold mt-1">
                                @if($patient->status === 'active')
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                        Active Patient
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </p>

                            <!-- Info Grid -->
                            <div class="space-y-4 mt-6 pt-6 border-t border-gray-200">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Card ID</p>
                                    <p class="text-lg font-bold text-gray-900 mt-1">{{ $patient->id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</p>
                                    <p class="text-sm text-gray-700 mt-1 break-all">{{ $patient->user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</p>
                                    <p class="text-sm text-gray-700 mt-1">{{ $patient->user->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Assigned Agent</p>
                                    <p class="text-sm text-gray-700 mt-1">
                                        {{ $patient->agent?->user->name ?? 'Not Assigned' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="space-y-2 mt-6 pt-6 border-t border-gray-200">
                                <!-- Card Download Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.patients.card', $patient) }}" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-smooth flex items-center justify-center gap-2 text-sm">
                                        <x-heroicon-s-arrow-down-tray class="w-4 h-4" />
                                        Download Card
                                    </a>
                                    <a href="{{ route('admin.patients.acknowledgement', $patient) }}" class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-smooth flex items-center justify-center gap-2 text-sm">
                                        <x-heroicon-s-document class="w-4 h-4" />
                                        Acknowledgement
                                    </a>
                                </div>
                                <!-- Edit & Delete Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.patients.edit', $patient) }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2">
                                        <x-heroicon-s-pencil-square class="w-4 h-4" />
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.patients.destroy', $patient) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this patient?');">
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
                </div>

                <!-- Visits Table -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Card Preview Section -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden" x-data="{ cardSide: 'front' }">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <x-heroicon-s-credit-card class="w-5 h-5 text-blue-600" />
                                Health Card Preview
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-center gap-4 mb-6">
                                <button 
                                    @click="cardSide = 'front'"
                                    :class="cardSide === 'front' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                                    class="px-6 py-2 rounded-lg font-semibold transition-smooth"
                                >
                                    Front Side
                                </button>
                                <button 
                                    @click="cardSide = 'back'"
                                    :class="cardSide === 'back' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                                    class="px-6 py-2 rounded-lg font-semibold transition-smooth"
                                >
                                    Back Side
                                </button>
                            </div>
                            <div class="flex justify-center">
                                <embed 
                                    :src="cardSide === 'front' ? '{{ route('admin.patients.card', $patient) }}?preview=true#page=1' : '{{ route('admin.patients.card', $patient) }}?preview=true#page=2'"
                                    type="application/pdf"
                                    class="w-full h-96 rounded-lg border-2 border-gray-300"
                                />
                            </div>
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.patients.card', $patient) }}" download class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-smooth">
                                    <x-heroicon-s-arrow-down-tray class="w-4 h-4" />
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- ID Proof Image Section -->
                    @if($patient->address_proof_file && file_exists(public_path('storage/' . $patient->address_proof_file)))
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <x-heroicon-s-document class="w-5 h-5 text-purple-600" />
                                    ID Proof ({{ ucfirst(str_replace('_', ' ', $patient->address_proof_type)) }})
                                </h3>
                            </div>
                            <div class="p-6 flex justify-center">
                                @php
                                    $extension = strtolower(pathinfo(public_path('storage/' . $patient->address_proof_file), PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                @endphp
                                
                                @if($isImage)
                                    <img src="{{ asset('storage/' . $patient->address_proof_file) }}" alt="ID Proof" class="max-w-full max-h-96 rounded-lg shadow-md">
                                @else
                                    <embed 
                                        src="{{ asset('storage/' . $patient->address_proof_file) }}" 
                                        type="application/pdf"
                                        class="w-full h-96 rounded-lg border-2 border-gray-300"
                                    />
                                @endif
                            </div>
                            <div class="px-6 py-4 border-t border-gray-200 text-center">
                                <a href="{{ asset('storage/' . $patient->address_proof_file) }}" download class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-smooth text-sm">
                                    <x-heroicon-s-arrow-down-tray class="w-4 h-4" />
                                    Download
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Address Section -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
                            <x-heroicon-s-map-pin class="w-5 h-5 text-blue-600" />
                            Address
                        </h3>
                        <p class="text-gray-700 leading-relaxed">{{ $patient->address ?? 'Not provided' }}</p>
                    </div>

                    <!-- Recent Visits -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <x-heroicon-s-clipboard class="w-5 h-5 text-green-600" />
                                Recent Visits ({{ $visits->count() }})
                            </h3>
                        </div>

                        @if($visits->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Provider</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Discount</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($visits->take(10) as $visit)
                                            <tr class="hover:bg-gray-50 transition-smooth">
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    {{ $visit->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-semibold text-gray-900">{{ $visit->vendor->user->name }}</span>
                                                        <span class="text-xs text-gray-500">{{ $visit->vendor->user->phone }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $typeColors = [
                                                            'hospital' => 'bg-red-100 text-red-700',
                                                            'clinic' => 'bg-blue-100 text-blue-700',
                                                            'diagnostic' => 'bg-purple-100 text-purple-700',
                                                            'pharmacy' => 'bg-green-100 text-green-700',
                                                        ];
                                                        $color = $typeColors[$visit->vendor->provider_type] ?? 'bg-gray-100 text-gray-700';
                                                    @endphp
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                                        {{ ucfirst($visit->vendor->provider_type) }}
                                                    </span>
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
                        @else
                            <div class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                    <x-heroicon-s-document-text class="w-8 h-8 text-gray-400" />
                                </div>
                                <p class="text-gray-600 font-medium">No visits found</p>
                                <p class="text-sm text-gray-500">This patient hasn't made any visits yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Statistics -->
                    @if($visits->count() > 0)
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Total Visits</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">{{ $visits->count() }}</p>
                            </div>
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Total Savings</p>
                                <p class="text-2xl font-bold text-green-600 mt-2">₹{{ number_format($visits->sum('discount_amount'), 2) }}</p>
                            </div>
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                                <p class="text-xs font-semibold text-gray-500 uppercase">Avg. Discount</p>
                                <p class="text-2xl font-bold text-blue-600 mt-2">{{ number_format($visits->avg('discount_amount'), 2) }}%</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
