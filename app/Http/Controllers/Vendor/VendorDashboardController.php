<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class VendorDashboardController extends Controller
{
    public function index(): View
    {
        $vendor = request()->user()->vendor;
        $vendor->load('user');

        // Calculate statistics
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();

        $todayVisits = Visit::where('vendor_id', $vendor->id)
            ->whereDate('visited_at', $today)
            ->count();

        $monthlyVisits = Visit::where('vendor_id', $vendor->id)
            ->whereBetween('visited_at', [$monthStart, Carbon::now()])
            ->count();

        $monthlyRevenue = Visit::where('vendor_id', $vendor->id)
            ->whereBetween('visited_at', [$monthStart, Carbon::now()])
            ->sum('discount_amount');

        $pendingSettlement = Visit::where('vendor_id', $vendor->id)
            ->whereNull('settled_at')
            ->sum('discount_amount');

        $pendingVisits = Visit::where('vendor_id', $vendor->id)
            ->whereNull('settled_at')
            ->count();

        $recentVisits = Visit::where('vendor_id', $vendor->id)
            ->with(['patient.user', 'vendor.user'])
            ->latest('visited_at')
            ->take(5)
            ->get();

        $stats = [
            'todayVisits' => $todayVisits,
            'todayIncrease' => 12,
            'monthlyBills' => $monthlyVisits,
            'billsIncrease' => 8,
            'monthlyRevenue' => $monthlyRevenue,
            'revenueIncrease' => 15,
            'pendingSettlement' => $pendingSettlement,
            'pendingVisits' => $pendingVisits,
        ];

        return view('vendor.dashboard', [
            'vendor' => $vendor,
            'stats' => $stats,
            'recentVisits' => $recentVisits,
        ]);
    }
}
