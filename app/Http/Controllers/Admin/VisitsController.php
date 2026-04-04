<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VisitsController extends Controller
{
    /**
     * Display all visits with filtering
     */
    public function index(Request $request): View
    {
        $query = Visit::query()
            ->with(['patient.user', 'vendor.user'])
            ->latest('visited_at');

        // Filter by patient
        if ($request->filled('patient_search')) {
            $query->whereHas('patient.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->patient_search . '%');
            });
        }

        // Filter by vendor
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('visited_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('visited_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Filter by verification method
        if ($request->filled('verification_method')) {
            $query->where('verification_method', $request->verification_method);
        }

        $visits = $query->paginate(30);

        $stats = [
            'total_visits' => Visit::count(),
            'total_discounts' => Visit::sum('discount_amount'),
            'total_original_amount' => Visit::sum('original_amount'),
            'qr_scans' => Visit::where('verification_method', 'qr')->count(),
            'mobile_scans' => Visit::where('verification_method', 'mobile')->count(),
        ];

        return view('admin.visits.index', compact('visits', 'stats'));
    }

    /**
     * Show visit details
     */
    public function show(Visit $visit): View
    {
        $visit->load(['patient.user', 'vendor.user', 'vendor']);
        return view('admin.visits.show', compact('visit'));
    }

    /**
     * Show edit form
     */
    public function edit(Visit $visit): View
    {
        return view('admin.visits.edit', compact('visit'));
    }

    /**
     * Update visit record
     */
    public function update(Request $request, Visit $visit): RedirectResponse
    {
        $validated = $request->validate([
            'original_amount' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'service_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate new discount amount
        $validated['discount_amount'] = round(
            ($validated['original_amount'] * $validated['discount_percentage']) / 100,
            2
        );

        $visit->update($validated);

        return redirect()->route('admin.visits.show', $visit)->with('success', 'Visit updated successfully');
    }

    /**
     * Delete visit record
     */
    public function destroy(Visit $visit): RedirectResponse
    {
        $visit->delete();
        return redirect()->route('admin.visits.index')->with('success', 'Visit deleted successfully');
    }

    /**
     * Export visits to CSV
     */
    public function export()
    {
        $visits = Visit::with(['patient.user', 'vendor.user'])->get();

        $csv = "Date,Patient ID,Patient Name,Vendor Name,Service Type,Original Amount,Discount %,Discount Amount,Verification Method\n";

        foreach ($visits as $visit) {
            $csv .= sprintf(
                '"%s",%d,"%s","%s","%s",%.2f,%d,%.2f,%s' . "\n",
                $visit->visited_at->format('d-m-Y H:i'),
                $visit->patient_id,
                $visit->patient->user->name ?? '',
                $visit->vendor->user->name ?? '',
                $visit->service_type ?? 'N/A',
                $visit->original_amount,
                $visit->discount_percentage,
                $visit->discount_amount,
                $visit->verification_method
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="visits_' . date('Y-m-d_H-i-s') . '.csv"');
    }
}
