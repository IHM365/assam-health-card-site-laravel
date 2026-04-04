@props([
    'title' => null,
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Assam Health Card') }}</title>

        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/images/ahc-logo.svg">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" x-cloak x-data="{ navOpen: false }">
        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Main Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white py-12 mt-16 border-t border-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <x-application-logo class="w-8 h-8" />
                                <span class="font-bold text-lg">Assam Health Card</span>
                            </div>
                            <p class="text-gray-400 text-sm">Making quality healthcare affordable and accessible for every family in Assam.</p>
                        </div>
                        
                        <div>
                            <h4 class="font-semibold mb-4">Quick Links</h4>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li><a href="{{ route('patient.dashboard') }}" class="hover:text-white transition">Dashboard</a></li>
                                <li><a href="{{ route('patient.card.show') }}" class="hover:text-white transition">My Card</a></li>
                                <li><a href="{{ route('patient.visits.index') }}" class="hover:text-white transition">Visits</a></li>
                                <li><a href="{{ route('patient.vendors.index') }}" class="hover:text-white transition">Partners</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-4">Support</h4>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li><a href="{{ route('public.faq') }}" class="hover:text-white transition">FAQ</a></li>
                                <li><a href="{{ route('public.contact') }}" class="hover:text-white transition">Contact Us</a></li>
                                <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                                <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-4">About</h4>
                            <ul class="space-y-2 text-sm text-gray-400">
                                <li><a href="{{ route('public.about') }}" class="hover:text-white transition">About Us</a></li>
                                <li><a href="{{ route('public.pricing') }}" class="hover:text-white transition">Pricing</a></li>
                                <li><a href="{{ route('public.vendors') }}" class="hover:text-white transition">Our Network</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-t border-gray-800 pt-8">
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <p class="text-gray-400 text-sm">&copy; 2026 Assam Health Card. All rights reserved.</p>
                            <div class="flex gap-4 mt-4 md:mt-0">
                                <a href="#" class="text-gray-400 hover:text-white transition">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20v-7.21H5.5V9.25h2.79V7.07c0-2.77 1.69-4.28 4.16-4.28 1.18 0 2.2.09 2.49.13v2.89h-1.71c-1.34 0-1.6.64-1.6 1.57v2.06h3.2l-.42 3.54h-2.78V20"></path></svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-white transition">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
