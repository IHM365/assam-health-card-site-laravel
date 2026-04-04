<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\View\View;
use Illuminate\Http\Request;

class VendorVisitsController extends Controller
{
    public function index(Request $request): View
    {
        $vendor = $request->user()->vendor;

        // Build query
        $query = Visit::query()
            ->with(['patient.user'])
            ->where('vendor_id', $vendor->id);

        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('visited_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('visited_at', '<=', $request->to_date);
        }

        // Filter by patient name
        if ($request->has('patient_name') && $request->patient_name) {
            $query->whereHas('patient.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_name . '%');
            });
        }

        // Filter by amount range
        if ($request->has('amount_range') && $request->amount_range) {
            $range = $request->amount_range;
            if ($range === '0-500') {
                $query->whereBetween('original_amount', [0, 500]);
            } elseif ($range === '500-1000') {
                $query->whereBetween('original_amount', [500, 1000]);
            } elseif ($range === '1000-5000') {
                $query->whereBetween('original_amount', [1000, 5000]);
            } elseif ($range === '5000+') {
                $query->where('original_amount', '>=', 5000);
            }
        }

        // Get paginated results
        $visits = $query->latest('visited_at')->paginate(20);

        // Calculate statistics
        $statsQuery = Visit::where('vendor_id', $vendor->id);

        // Apply same filters to stats
        if ($request->has('from_date') && $request->from_date) {
            $statsQuery->whereDate('visited_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date) {
            $statsQuery->whereDate('visited_at', '<=', $request->to_date);
        }
        if ($request->has('patient_name') && $request->patient_name) {
            $statsQuery->whereHas('patient.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_name . '%');
            });
        }
        if ($request->has('amount_range') && $request->amount_range) {
            $range = $request->amount_range;
            if ($range === '0-500') {
                $statsQuery->whereBetween('original_amount', [0, 500]);
            } elseif ($range === '500-1000') {
                $statsQuery->whereBetween('original_amount', [500, 1000]);
            } elseif ($range === '1000-5000') {
                $statsQuery->whereBetween('original_amount', [1000, 5000]);
            } elseif ($range === '5000+') {
                $statsQuery->where('original_amount', '>=', 5000);
            }
        }

        $stats = [
            'total_visits' => $statsQuery->count(),
            'total_discount' => $statsQuery->sum('discount_amount') ?? 0,
            'total_received' => $statsQuery->sum(
                \DB::raw('(original_amount - discount_amount)')
            ) ?? 0,
            'avg_discount' => $statsQuery->avg('discount_amount') ?? 0,
        ];

        return view('vendor.visits.index', compact('visits', 'stats'));
    }
}
