<x-layouts.public title="Reset password | Assam Health Card" metaDescription="Request a link to reset your Assam Health Card account password.">
    <section class="py-12 sm:py-16 lg:py-20">
        <div class="max-w-md mx-auto px-4 sm:px-6">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-slate-900">Forgot password</h1>
                <p class="mt-2 text-sm text-slate-600">
                    {{ __('No problem. Enter your email and we will send a reset link.') }}
                </p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-secondary-600 text-white text-sm font-semibold hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-slate-600">
                    <a href="{{ route('login') }}" class="font-semibold text-primary-700 hover:text-primary-800">Back to login</a>
                </p>
            </div>
        </div>
    </section>
</x-layouts.public>
