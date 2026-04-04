<x-layouts.app title="Edit Patient | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.patients.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back
                    </a>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Edit Patient</h1>
                <p class="text-gray-600 mt-2">Update patient information</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 animate-slide-in-up">
                <form method="POST" action="{{ route('admin.patients.update', $patient) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-user class="w-4 h-4 inline mr-2" />
                            Full Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $patient->user->name) }}"
                            placeholder="Enter patient's full name"
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
                            value="{{ old('email', $patient->user->email) }}"
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
                            value="{{ old('phone', $patient->user->phone) }}"
                            placeholder="10-digit phone number"
                            pattern="[0-9]{10}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            required
                        />
                        @error('phone')
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
                            placeholder="Enter patient's address"
                            rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                            required
                        >{{ old('address', $patient->address) }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Card Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-credit-card class="w-4 h-4 inline mr-2" />
                            Card Type
                        </label>
                        <select
                            name="card_type"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('card_type') border-red-500 @enderror"
                            required
                        >
                            <option value="">-- Select card type --</option>
                            <option value="individual" {{ old('card_type', $patient->card_type) === 'individual' ? 'selected' : '' }}>Individual Card</option>
                            <option value="family" {{ old('card_type', $patient->card_type) === 'family' ? 'selected' : '' }}>Family Card</option>
                        </select>
                        @error('card_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address Proof Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-document class="w-4 h-4 inline mr-2" />
                            Address Proof Type <span class="text-xs text-gray-500 font-normal">(Optional)</span>
                        </label>
                        <select
                            name="address_proof_type"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address_proof_type') border-red-500 @enderror"
                        >
                            <option value="">-- Select proof type --</option>
                            <option value="aadhar" {{ old('address_proof_type', $patient->address_proof_type) === 'aadhar' ? 'selected' : '' }}>Aadhar Card</option>
                            <option value="passport" {{ old('address_proof_type', $patient->address_proof_type) === 'passport' ? 'selected' : '' }}>Passport</option>
                            <option value="driving_license" {{ old('address_proof_type', $patient->address_proof_type) === 'driving_license' ? 'selected' : '' }}>Driving License</option>
                            <option value="utility_bill" {{ old('address_proof_type', $patient->address_proof_type) === 'utility_bill' ? 'selected' : '' }}>Utility Bill</option>
                            <option value="rental_agreement" {{ old('address_proof_type', $patient->address_proof_type) === 'rental_agreement' ? 'selected' : '' }}>Rental Agreement</option>
                            <option value="other" {{ old('address_proof_type', $patient->address_proof_type) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('address_proof_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address Proof File -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-document class="w-4 h-4 inline mr-2" />
                            Address Proof File <span class="text-xs text-gray-500 font-normal">(Optional - PDF, JPG, PNG up to 5MB)</span>
                        </label>
                        @if($patient->address_proof_file)
                            <p class="text-sm text-gray-600 mb-2">Current file: <a href="{{ asset('storage/' . $patient->address_proof_file) }}" target="_blank" class="text-blue-600 hover:underline font-semibold">View</a></p>
                        @endif
                        <input
                            type="file"
                            name="address_proof_file"
                            accept="application/pdf,image/jpeg,image/png"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address_proof_file') border-red-500 @enderror file:mr-3 file:px-3 file:py-2 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        />
                        @error('address_proof_file')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-user-circle class="w-4 h-4 inline mr-2" />
                            Profile Image <span class="text-xs text-gray-500 font-normal">(Optional - JPG, PNG up to 2MB)</span>
                        </label>
                        @if($patient->profile_image && file_exists(public_path($patient->profile_image)))
                            <p class="text-sm text-gray-600 mb-2">
                                <img src="{{ asset($patient->profile_image) }}" alt="Current profile" class="max-w-xs max-h-32 rounded-lg border-2 border-gray-200 inline-block" />
                            </p>
                        @endif
                        <div class="relative">
                            <input
                                type="file"
                                name="profile_image"
                                accept="image/jpeg,image/png"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('profile_image') border-red-500 @enderror file:mr-3 file:px-3 file:py-2 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                id="profile_image"
                            />
                            <img id="preview" class="mt-2 max-w-xs max-h-32 rounded-lg border-2 border-gray-200 hidden" alt="Profile preview" />
                        </div>
                        @error('profile_image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Card Validity Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-calendar class="w-4 h-4 inline mr-2" />
                            Card Validity Date <span class="text-xs text-gray-500 font-normal">(Optional - auto-inactive after expiry)</span>
                        </label>
                        <input
                            type="date"
                            name="card_validity_date"
                            value="{{ old('card_validity_date', $patient->card_validity_date?->format('Y-m-d')) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('card_validity_date') border-red-500 @enderror"
                        />
                        @error('card_validity_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password (Optional) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-key class="w-4 h-4 inline mr-2" />
                            Password <span class="text-xs text-gray-500 font-normal">(Optional - leave blank to keep current)</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Leave blank to keep current password"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                        />
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        document.getElementById('profile_image').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(event) {
                                    const preview = document.getElementById('preview');
                                    preview.src = event.target.result;
                                    preview.classList.remove('hidden');
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

                    <!-- Agent Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-user-group class="w-4 h-4 inline mr-2" />
                            Assigned Agent
                        </label>
                        <select
                            name="agent_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">-- Select an agent (Optional) --</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('agent_id', $patient->agent_id) == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->user->name }} ({{ $agent->user->phone }})
                                </option>
                            @endforeach
                        </select>
                        @error('agent_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <x-heroicon-s-check-circle class="w-4 h-4 inline mr-2" />
                            Status
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input
                                    type="radio"
                                    name="status"
                                    value="active"
                                    {{ old('status', $patient->status) === 'active' ? 'checked' : '' }}
                                    class="w-4 h-4"
                                />
                                <span class="text-sm font-medium text-gray-700">Active</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input
                                    type="radio"
                                    name="status"
                                    value="inactive"
                                    {{ old('status', $patient->status) === 'inactive' ? 'checked' : '' }}
                                    class="w-4 h-4"
                                />
                                <span class="text-sm font-medium text-gray-700">Inactive</span>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.patients.show', $patient) }}" class="flex-1 px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-smooth text-center">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="flex-1 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2"
                        >
                            <x-heroicon-s-check class="w-5 h-5" />
                            Update Patient
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
