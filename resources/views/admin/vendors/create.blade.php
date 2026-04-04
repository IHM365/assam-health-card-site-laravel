<x-layouts.app title="Register Vendor | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.vendors.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back
                    </a>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Register New Vendor</h1>
                <p class="text-gray-600 mt-2">Add a new healthcare partner to the system</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 animate-slide-in-up">
                <form method="POST" action="{{ route('admin.vendors.store') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-building-storefront class="w-4 h-4 inline mr-2" />
                            Organization Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter organization name"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            required
                        />
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-envelope class="w-4 h-4 inline mr-2" />
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter email address"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            required
                        />
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-phone class="w-4 h-4 inline mr-2" />
                            Phone Number
                        </label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="10-digit phone number"
                            pattern="[0-9]{10}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            required
                        />
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-tag class="w-4 h-4 inline mr-2" />
                            Provider Type
                        </label>
                        <select
                            name="type"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Select Type --</option>
                            <option value="hospital" {{ old('type') === 'hospital' ? 'selected' : '' }}>Hospital</option>
                            <option value="clinic" {{ old('type') === 'clinic' ? 'selected' : '' }}>Clinic</option>
                            <option value="diagnostic" {{ old('type') === 'diagnostic' ? 'selected' : '' }}>Diagnostic Center</option>
                            <option value="pharmacy" {{ old('type') === 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                        </select>
                        @error('type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-map-pin class="w-4 h-4 inline mr-2" />
                            Address
                        </label>
                        <textarea
                            name="address"
                            placeholder="Enter full address"
                            rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                            required
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Discount Percentage -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-percent-badge class="w-4 h-4 inline mr-2" />
                            Discount Percentage
                        </label>
                        <div class="relative">
                            <input
                                type="number"
                                name="discount_percentage"
                                value="{{ old('discount_percentage', 0) }}"
                                placeholder="0-100"
                                min="0"
                                max="100"
                                step="0.1"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('discount_percentage') border-red-500 @enderror"
                                required
                            />
                            <span class="absolute right-4 top-3 text-gray-500 font-semibold">%</span>
                        </div>
                        @error('discount_percentage')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password (Optional) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-key class="w-4 h-4 inline mr-2" />
                            Password <span class="text-xs text-gray-500 font-normal">(Optional - leave blank for auto-generated)</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Leave blank for auto-generated password"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                        />
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.vendors.index') }}" class="flex-1 px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-smooth text-center">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="flex-1 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2"
                        >
                            <x-heroicon-s-check class="w-5 h-5" />
                            Register Vendor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
