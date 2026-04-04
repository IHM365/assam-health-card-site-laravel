<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VendorBillController extends Controller
{
    /**
     * Show upload bill page
     */
    public function index(): View
    {
        $vendor = auth()->user()->vendor;
        
        // Get statistics for dashboard
        $stats = [
            'total_bills' => Visit::where('vendor_id', $vendor->id)->count(),
            'total_amount' => Visit::where('vendor_id', $vendor->id)->sum('original_amount'),
            'total_discount' => Visit::where('vendor_id', $vendor->id)->sum('discount_amount'),
        ];
        
        return view('vendor.bills.index', compact('stats'));
    }

    /**
     * Handle bill upload or manual entry
     */
    public function upload(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'patient_phone' => 'required|digits:10',
                'service_type' => 'required|string|max:255',
                'original_amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:1000',
                'bill_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
            ]);

            $vendor = auth()->user()->vendor;
            
            // Find patient by phone
            $patient = \App\Models\Patient::whereHas('user', function ($query) use ($request) {
                $query->where('phone', $request->patient_phone);
            })->first();

            if (!$patient) {
                return redirect()->back()->with('error', 'Patient not found with this phone number');
            }

            // Calculate discount
            $originalAmount = (float) $validated['original_amount'];
            $discountPercentage = (int) ($vendor->discount_percentage ?? 0);
            $discountAmount = round(($originalAmount * $discountPercentage) / 100, 2);

            // Store bill file if uploaded
            $billPath = null;
            if ($request->hasFile('bill_file')) {
                $billPath = $request->file('bill_file')->store('bills', 'public');
            }

            // Create visit record
            $visit = Visit::create([
                'patient_id' => $patient->id,
                'vendor_id' => $vendor->id,
                'discount_percentage' => $discountPercentage,
                'discount_amount' => $discountAmount,
                'original_amount' => $originalAmount,
                'service_type' => $validated['service_type'],
                'notes' => $validated['notes'],
                'verification_method' => 'bill', // Different from QR/Mobile
                'visited_at' => now(),
            ]);

            return redirect()->route('vendor.visits.index')
                ->with('success', "Bill recorded successfully! Patient {$patient->user->name} received ₹{$discountAmount} discount");

        } catch (\Exception $e) {
            \Log::error('Bill upload failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to record bill: ' . $e->getMessage());
        }
    }
}
