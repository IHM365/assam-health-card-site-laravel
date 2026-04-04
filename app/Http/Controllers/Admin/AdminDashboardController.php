<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Patient;
use App\Models\Vendor;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalPatients = Patient::query()->count();
        $activeVendors = Vendor::query()->where('status', 'approved')->count();
        $totalVisits = Visit::query()->count();
        $monthlyRevenue = Visit::query()
            ->whereBetween('visited_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('discount_amount');

        $totalRevenue = Visit::query()->sum('discount_amount');
        $monthlyVisits = Visit::query()
            ->whereBetween('visited_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        // Recent activities
        $recentPatients = Patient::query()
            ->with('user', 'agent.user')
            ->latest()
            ->limit(5)
            ->get();

        $recentVendors = Vendor::query()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentVisits = Visit::query()
            ->with(['patient.user', 'vendor.user'])
            ->latest('visited_at')
            ->limit(10)
            ->get();

        $pendingVendors = Vendor::query()->where('status', 'pending')->count();

        // Growth metrics
        $lastMonthVisits = Visit::query()
            ->whereBetween('visited_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->count();

        $visitGrowth = $lastMonthVisits > 0 
            ? round((($monthlyVisits - $lastMonthVisits) / $lastMonthVisits) * 100, 1)
            : 0;

        return view('admin.dashboard', [
            'stats' => [
                'patients' => $totalPatients,
                'activeVendors' => $activeVendors,
                'vendors' => Vendor::query()->count(),
                'visits' => $totalVisits,
                'monthlyRevenue' => $monthlyRevenue,
                'totalRevenue' => $totalRevenue,
                'monthlyVisits' => $monthlyVisits,
                'pendingVendors' => $pendingVendors,
            ],
            'recentPatients' => $recentPatients,
            'recentVendors' => $recentVendors,
            'recentVisits' => $recentVisits,
            'visitGrowth' => $visitGrowth,
        ]);
    }
}
