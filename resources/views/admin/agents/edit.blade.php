<x-layouts.app title="Edit Agent | Assam Health Card">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-green-50 to-blue-50 py-8 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8 animate-slide-in-down">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.agents.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium">
                        <x-heroicon-s-arrow-left class="w-5 h-5" />
                        Back
                    </a>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Edit Agent</h1>
                <p class="text-gray-600 mt-2">Update agent information</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 animate-slide-in-up">
                <form method="POST" action="{{ route('admin.agents.update', $agent) }}" class="space-y-6">
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
                            value="{{ old('name', $agent->user->name) }}"
                            placeholder="Enter agent's full name"
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
                            value="{{ old('email', $agent->user->email) }}"
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
                            value="{{ old('phone', $agent->user->phone) }}"
                            placeholder="10-digit phone number"
                            pattern="[0-9]{10}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                            required
                        />
                        @error('phone')
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

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.agents.show', $agent) }}" class="flex-1 px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-smooth text-center">
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="flex-1 px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2"
                        >
                            <x-heroicon-s-check class="w-5 h-5" />
                            Update Agent
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
