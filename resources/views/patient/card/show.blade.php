<x-layouts.app title="My Health Card | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900">My Health Card</h1>
                        <p class="text-gray-600 mt-2">Your official Assam Health Card</p>
                    </div>
                    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Digital Card -->
                <div class="lg:col-span-2 animate-slide-in-up" style="animation-delay: 0.1s;">
                    <!-- Card Design -->
                    <div class="bg-gradient-to-br from-blue-600 to-green-600 rounded-3xl p-8 text-white shadow-2xl mb-8">
                        <!-- Card Header -->
                        <div class="flex items-start justify-between mb-12">
                            <div>
                                <h2 class="text-2xl font-bold">Assam Health Card</h2>
                                <p class="text-blue-100 text-sm mt-1">Official Health ID</p>
                            </div>
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <x-heroicon-s-check-circle class="w-8 h-8 text-white" />
                            </div>
                        </div>

                        <!-- Card Details Grid -->
                        <div class="grid grid-cols-2 gap-8 mb-12 pb-12 border-b border-white border-opacity-30">
                            <div>
                                <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">Patient ID</p>
                                <p class="text-3xl font-bold mt-2">{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">Card Status</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                                    <p class="text-xl font-bold">{{ ucfirst($patient->status) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Holder Information -->
                        <div>
                            <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">Cardholder Name</p>
                            <p class="text-2xl font-semibold mt-2">{{ $patient->name }}</p>
                            <div class="grid grid-cols-2 gap-6 mt-6 text-sm">
                                <div>
                                    <p class="text-blue-100">Phone</p>
                                    <p class="font-medium">{{ $patient->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-blue-100">Valid Until</p>
                                    <p class="font-medium">Dec 2026</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Info & Actions -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Card Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <x-heroicon-s-identification class="w-5 h-5 text-blue-600" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Patient ID</p>
                                        <p class="text-xl font-bold text-blue-600 mt-1">{{ str_pad($patient->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <x-heroicon-s-check-circle class="w-5 h-5 text-green-600" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Status</p>
                                        <p class="text-xl font-bold text-green-600 mt-1">{{ ucfirst($patient->status) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-purple-50 rounded-lg border border-purple-100">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <x-heroicon-s-calendar class="w-5 h-5 text-purple-600" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Valid Until</p>
                                        <p class="text-xl font-bold text-purple-600 mt-1">Dec 2026</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-orange-50 rounded-lg border border-orange-100">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                        <x-heroicon-s-map-pin class="w-5 h-5 text-orange-600" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Address</p>
                                        <p class="text-lg font-bold text-orange-600 mt-1">{{ $patient->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 flex gap-3">
                            <a href="{{ route('public.card.show', $patient->id) }}" target="_blank" rel="noreferrer" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth">
                                <x-heroicon-s-printer class="w-5 h-5" />
                                Print Card
                            </a>
                            <button onclick="window.print()" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition-smooth">
                                <x-heroicon-s-arrow-down-tray class="w-5 h-5" />
                                Download
                            </button>
                        </div>
                    </div>
                </div>

                <!-- QR Code Sidebar -->
                <div class="animate-slide-in-up" style="animation-delay: 0.2s;">
                    <!-- Verification QR Code -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm sticky top-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Verification QR</h3>
                        <p class="text-sm text-gray-600 mb-6">Show this code to verify your card at partner healthcare centers</p>

                        <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300 flex flex items-center justify-center">
                            {!! QrCode::size(220)->margin(1)->generate($verifyUrl) !!}
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-xs text-gray-500 mb-3 font-semibold">Scan with partner app</p>
                            <div class="flex gap-2">
                                <a href="#" class="flex-1 p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-smooth text-center">
                                    <x-heroicon-s-qr-code class="w-6 h-6 text-gray-700 mx-auto" />
                                    <span class="text-xs font-medium text-gray-700 block mt-1">iOS</span>
                                </a>
                                <a href="#" class="flex-1 p-3 bg-gray-100 rounded-lg hover:bg-gray-200 transition-smooth text-center">
                                    <x-heroicon-s-qr-code class="w-6 h-6 text-gray-700 mx-auto" />
                                    <span class="text-xs font-medium text-gray-700 block mt-1">Android</span>
                                </a>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div class="mt-8 space-y-3">
                            <a href="{{ route('patient.visits.index') }}" class="block w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-lg font-medium hover:bg-blue-100 transition-smooth text-center">
                                View Visits
                            </a>
                            <a href="{{ route('patient.vendors.index') }}" class="block w-full px-4 py-3 bg-green-50 text-green-700 rounded-lg font-medium hover:bg-green-100 transition-smooth text-center">
                                Find Partners
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

