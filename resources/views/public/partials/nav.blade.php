<nav class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between gap-4">
            <a href="{{ route('public.home') }}" class="flex items-center gap-2.5 shrink-0 min-w-0">
                <img src="{{ asset('images/ahc-logo.svg') }}" alt="" width="40" height="40" class="h-9 w-9 sm:h-10 sm:w-10 shrink-0" />
                <span class="font-bold text-slate-900 text-base sm:text-lg truncate">Assam Health Card</span>
            </a>

            <div class="hidden md:flex items-center gap-1 lg:gap-2 text-sm font-medium text-slate-700">
                <a href="{{ route('public.home') }}" class="rounded-lg px-3 py-2 hover:bg-primary-50 hover:text-primary-800">Home</a>
                <a href="{{ route('public.about') }}" class="rounded-lg px-3 py-2 hover:bg-primary-50 hover:text-primary-800">About</a>
                <a href="{{ route('public.pricing') }}" class="rounded-lg px-3 py-2 hover:bg-primary-50 hover:text-primary-800">Pricing</a>
                <a href="{{ route('public.vendors') }}" class="rounded-lg px-3 py-2 hover:bg-primary-50 hover:text-primary-800">Find providers</a>
                <a href="{{ route('public.contact') }}" class="rounded-lg px-3 py-2 hover:bg-secondary-50 hover:text-secondary-800">Contact</a>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                @auth
                    <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-primary-600 text-white hover:bg-primary-700 shadow-sm">
                        My account
                    </a>
                @else
                    <a href="{{ route('public.contact') }}" class="hidden sm:inline-flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100">
                        Get your card
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-secondary-600 text-white hover:bg-secondary-700 shadow-sm">
                        Login
                    </a>
                @endauth

                <button type="button" class="md:hidden inline-flex items-center justify-center rounded-lg p-2 text-slate-700 hover:bg-slate-100" @click="mobileOpen = ! mobileOpen" :aria-expanded="mobileOpen" aria-label="Toggle menu">
                    <svg class="h-6 w-6" x-show="!mobileOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="h-6 w-6" x-cloak x-show="mobileOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div class="md:hidden border-t border-slate-100 py-4 space-y-1" x-show="mobileOpen" x-cloak x-transition>
            <a href="{{ route('public.home') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-800 hover:bg-primary-50">Home</a>
            <a href="{{ route('public.about') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-800 hover:bg-primary-50">About</a>
            <a href="{{ route('public.pricing') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-800 hover:bg-primary-50">Pricing</a>
            <a href="{{ route('public.vendors') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-800 hover:bg-primary-50">Find providers</a>
            <a href="{{ route('public.contact') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-800 hover:bg-primary-50">Contact</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-primary-800">My account</a>
            @else
                <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-secondary-700">Login</a>
            @endauth
        </div>
    </div>
</nav>
