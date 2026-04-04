<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Vendor Portal' }} | Assam Health Card</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- QR Code Scanner Library -->
        <script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.4/dist/html5-qrcode.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex flex-col">
            @include('vendor.layouts.navigation')

            <div class="flex flex-1">
                <!-- Sidebar Menu -->
                <div class="w-64 bg-white border-r border-gray-200 hidden md:block">
                    @include('vendor.layouts.menu')
                </div>

                <!-- Main Content -->
                <div class="flex-1 overflow-auto">
                    <!-- Page Content -->
                    <main class="py-8 px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </main>

                    <!-- Footer -->
                    <footer class="bg-gray-900 text-gray-400 border-t border-gray-800 mt-auto">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                            <p class="text-center text-sm">
                                &copy; {{ date('Y') }} Assam Health Card. All rights reserved.
                            </p>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
