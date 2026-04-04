<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class VendorReportController extends Controller
{
    /**
     * Show monthly report
     */
    public function monthlyReport(Request $request): View
    {
        $vendor = auth()->user()->vendor;
        $vendor->load('user');

        // Get month and year from request or default to current
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Get visits for the month
        $monthlyVisits = Visit::where('vendor_id', $vendor->id)
            ->whereBetween('visited_at', [$startDate, $endDate])
            ->with(['patient.user'])
            ->latest('visited_at')
            ->get();

        // Calculate statistics
        $stats = [
            'total_visits' => $monthlyVisits->count(),
            'total_amount' => $monthlyVisits->sum('original_amount'),
            'total_discount' => $monthlyVisits->sum('discount_amount'),
            'average_discount' => $monthlyVisits->count() > 0 ? $monthlyVisits->avg('discount_percentage') : 0,
            'qr_scans' => $monthlyVisits->where('verification_method', 'qr')->count(),
            'mobile_scans' => $monthlyVisits->where('verification_method', 'mobile')->count(),
            'bill_uploads' => $monthlyVisits->where('verification_method', 'bill')->count(),
        ];

        // Get last 12 months data for chart
        $chartData = $this->getMonthlyChartData($vendor->id);

        // Top services
        $topServices = $monthlyVisits->groupBy('service_type')
            ->map(fn($items) => [
                'service' => $items->first()->service_type ?? 'Not Specified',
                'count' => $items->count(),
                'amount' => $items->sum('original_amount'),
            ])
            ->values()
            ->sortByDesc('amount')
            ->take(5);

        return view('vendor.reports.monthly', [
            'vendor' => $vendor,
            'month' => $month,
            'year' => $year,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'monthlyVisits' => $monthlyVisits,
            'stats' => $stats,
            'chartData' => $chartData,
            'topServices' => $topServices,
        ]);
    }

    /**
     * Get monthly chart data for last 12 months
     */
    private function getMonthlyChartData(int $vendorId): array
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startDate = $date->startOfMonth();
            $endDate = $date->endOfMonth();

            $total = Visit::where('vendor_id', $vendorId)
                ->whereBetween('visited_at', [$startDate, $endDate])
                ->sum('discount_amount');

            $data[] = [
                'month' => $date->format('M'),
                'value' => $total,
            ];
        }
        return $data;
    }
}
