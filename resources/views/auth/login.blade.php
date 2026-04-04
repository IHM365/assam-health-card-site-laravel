<x-layouts.public title="Patient login | Assam Health Card" metaDescription="Sign in to your Assam Health Card patient account.">
    <section class="py-12 sm:py-16 lg:py-20">
        <div class="max-w-md mx-auto px-4 sm:px-6">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-slate-900">Login</h1>
                <p class="mt-2 text-sm text-slate-600">Access your health card, visits, and profile. Accounts are issued when you enroll through AHC.</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="login" :value="__('Email or Phone')" />
                        <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('login')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-secondary-600 shadow-sm focus:ring-secondary-500" name="remember">
                            <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4 mt-6">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-secondary-700 hover:text-secondary-900 font-medium" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-secondary-600 text-white text-sm font-semibold hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2 w-full sm:w-auto">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>

                <p class="mt-8 pt-6 border-t border-slate-100 text-center text-sm text-slate-600">
                    Need a card or login details?
                    <a href="{{ route('public.contact') }}" class="font-semibold text-primary-700 hover:text-primary-800">Contact us</a>
                </p>
            </div>
        </div>
    </section>
</x-layouts.public>
