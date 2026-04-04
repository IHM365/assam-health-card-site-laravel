<div class="px-4 py-6 space-y-4">
    <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu</h3>

    <!-- Overview -->
    <a href="{{ route('vendor.dashboard') }}" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('vendor.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-smooth">
        <x-heroicon-s-squares-2x2 class="w-5 h-5" />
        <span class="font-medium">Overview</span>
    </a>

    <!-- Scan Card -->
    <a href="{{ route('vendor.scan.index') }}" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('vendor.scan.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-smooth">
        <x-heroicon-s-qr-code class="w-5 h-5" />
        <span class="font-medium">Scan Card</span>
    </a>

    <!-- Visit History -->
    <a href="{{ route('vendor.visits.index') }}" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('vendor.visits.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-smooth">
        <x-heroicon-s-clock class="w-5 h-5" />
        <span class="font-medium">Visit History</span>
    </a>

    <!-- Upload Bill (Disabled for Now) -->
    <!-- <a href="{{ route('vendor.bills.index') }}" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('vendor.bills.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-smooth">
        <x-heroicon-s-arrow-up-tray class="w-5 h-5" />
        <span class="font-medium">Upload Bill</span>
    </a> -->

    <!-- Reports -->
    <a href="{{ route('vendor.reports.monthly') }}" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('vendor.reports.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-smooth">
        <x-heroicon-s-document-chart-bar class="w-5 h-5" />
        <span class="font-medium">Reports</span>
    </a>

    <!-- Payments -->
    <a href="{{ route('vendor.payments.history') }}" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('vendor.payments.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-smooth">
        <x-heroicon-s-currency-rupee class="w-5 h-5" />
        <span class="font-medium">Payments</span>
    </a>

    <hr class="my-4">

    <!-- Profile -->
    <a href="{{ route('profile.edit') }}" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} transition-smooth">
        <x-heroicon-s-user-circle class="w-5 h-5" />
        <span class="font-medium">Profile</span>
    </a>

    <!-- Support -->
    <a href="#" 
       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 transition-smooth">
        <x-heroicon-s-question-mark-circle class="w-5 h-5" />
        <span class="font-medium">Support</span>
    </a>
</div>
