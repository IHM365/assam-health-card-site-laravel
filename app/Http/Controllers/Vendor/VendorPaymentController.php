<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class VendorPaymentController extends Controller
{
    /**
     * Show payment history
     */
    public function paymentHistory(Request $request): View
    {
        $vendor = auth()->user()->vendor;
        $vendor->load('user');

        $query = Visit::where('vendor_id', $vendor->id)
            ->with(['patient.user'])
            ->latest('visited_at');

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('visited_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('visited_at', '<=', $request->to_date . ' 23:59:59');
        }

        $visits = $query->paginate(20);

        // Calculate statistics
        $allTimeStats = Visit::where('vendor_id', $vendor->id);
        $filteredStats = clone $query;
        
        $allTimeTotalIncome = $allTimeStats->clone()->sum('original_amount');
        $filteredTotalIncome = $filteredStats->clone()->sum('original_amount');
        $adminCommissionRate = 3; // 3%
        $totalAdminPayment = round(($allTimeTotalIncome * $adminCommissionRate) / 100, 2);
        $periodAdminPayment = round(($filteredTotalIncome * $adminCommissionRate) / 100, 2);

        $stats = [
            'total_patients' => $visits->total(),
            'total_discount' => $filteredStats->clone()->sum('discount_amount'),
            'average_discount' => $filteredStats->clone()->avg('discount_amount'),
            'total_original_amount' => $filteredTotalIncome,
            'all_time_discount' => $allTimeStats->sum('discount_amount'),
            'total_visits_all_time' => $allTimeStats->count(),
            'all_time_income' => $allTimeTotalIncome,
            'admin_payment_owed' => $totalAdminPayment,
            'period_admin_payment' => $periodAdminPayment,
        ];

        // Get summary by month for current year
        $currentYear = now()->year;
        $monthlySummary = $this->getMonthlySummary($vendor->id, $currentYear);

        return view('vendor.payments.history', [
            'vendor' => $vendor,
            'visits' => $visits,
            'stats' => $stats,
            'monthlySummary' => $monthlySummary,
            'currentYear' => $currentYear,
        ]);
    }

    /**
     * Get monthly summary for the year
     */
    private function getMonthlySummary(int $vendorId, int $year): array
    {
        $months = [];
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            $visitCount = Visit::where('vendor_id', $vendorId)
                ->whereBetween('visited_at', [$startDate, $endDate])
                ->count();

            $totalDiscount = Visit::where('vendor_id', $vendorId)
                ->whereBetween('visited_at', [$startDate, $endDate])
                ->sum('discount_amount');

            $totalAmount = Visit::where('vendor_id', $vendorId)
                ->whereBetween('visited_at', [$startDate, $endDate])
                ->sum('original_amount');

            $months[] = [
                'month' => $month,
                'month_name' => Carbon::createFromDate($year, $month, 1)->format('F'),
                'visits_count' => $visitCount,
                'total_discount' => $totalDiscount,
                'total_amount' => $totalAmount,
            ];
        }
        return $months;
    }
}
