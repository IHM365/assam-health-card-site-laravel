<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class VendorScanController extends Controller
{
    /**
     * Show scan card page with QR scanner and mobile verification
     */
    public function index(): View
    {
        return view('vendor.scan.index');
    }

    /**
     * Verify patient using QR code (patient ID)
     */
    public function verifyByQr(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'patient_id' => 'required|integer|exists:patients,id',
            ]);

            $patient = Patient::with('user', 'agent.user')->find($request->patient_id);

            if (!$patient) {
                return response()->json(['success' => false, 'message' => 'Patient not found'], 404);
            }

            return response()->json([
                'success' => true,
                'patient' => [
                    'id' => $patient->id,
                    'name' => $patient->user->name,
                    'email' => $patient->user->email,
                    'phone' => $patient->user->phone,
                    'address' => $patient->address,
                    'card_type' => $patient->card_type,
                    'status' => $patient->status,
                    'profile_image' => $patient->profile_image,
                ],
                'agent' => $patient->agent ? [
                    'name' => $patient->agent->user->name,
                    'phone' => $patient->agent->user->phone,
                ] : null,
            ]);
        } catch (\Exception $e) {
            \Log::error('QR verification failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Verify patient using mobile number
     */
    public function verifyByMobile(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'phone' => 'required|digits:10',
            ]);

            $patient = Patient::whereHas('user', function ($query) use ($request) {
                $query->where('phone', $request->phone);
            })->with('user', 'agent.user')->first();

            if (!$patient) {
                return response()->json(['success' => false, 'message' => 'No patient found with this mobile number'], 404);
            }

            return response()->json([
                'success' => true,
                'patient' => [
                    'id' => $patient->id,
                    'name' => $patient->user->name,
                    'email' => $patient->user->email,
                    'phone' => $patient->user->phone,
                    'address' => $patient->address,
                    'card_type' => $patient->card_type,
                    'status' => $patient->status,
                    'profile_image' => $patient->profile_image,
                ],
                'agent' => $patient->agent ? [
                    'name' => $patient->agent->user->name,
                    'phone' => $patient->agent->user->phone,
                ] : null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Mobile verification failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Add discount and create visit record
     */
    public function storeDiscount(Request $request): RedirectResponse | JsonResponse
    {
        try {
            $request->validate([
                'patient_id' => 'required|integer|exists:patients,id',
                'original_amount' => 'required|numeric|min:0',
                'service_type' => 'nullable|string|max:255',
                'notes' => 'nullable|string|max:1000',
                'verification_method' => 'required|in:qr,mobile',
            ]);

            $vendor = auth()->user()->vendor;
            $patient = Patient::find($request->patient_id);

            // Calculate discount
            $originalAmount = (float) $request->original_amount;
            $discountPercentage = (int) ($vendor->discount_percentage ?? 0);
            $discountAmount = round(($originalAmount * $discountPercentage) / 100, 2);

            // Create visit record with complete tracking data
            $visit = Visit::create([
                'patient_id' => $patient->id,
                'vendor_id' => $vendor->id,
                'discount_percentage' => $discountPercentage,
                'discount_amount' => $discountAmount,
                'original_amount' => $originalAmount,
                'service_type' => $request->service_type,
                'notes' => $request->notes,
                'verification_method' => $request->verification_method,
                'visited_at' => Carbon::now(),
            ]);

            $visit->load('patient.user', 'vendor.user');

            // Check if AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Visit recorded successfully',
                    'visit' => [
                        'id' => $visit->id,
                        'original_amount' => $visit->original_amount,
                        'discount_percentage' => $visit->discount_percentage,
                        'discount_amount' => $visit->discount_amount,
                        'patient_name' => $visit->patient->user->name,
                        'vendor_name' => $visit->vendor->user->name,
                    ],
                ]);
            }

            // Redirect to discount summary for regular form submission
            return redirect()->route('vendor.scan.summary', $visit->id)->with('success', 'Visit recorded successfully!');
        } catch (\Exception $e) {
            \Log::error('Discount store failed', ['error' => $e->getMessage()]);
            
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show discount summary page
     */
    public function showSummary(Visit $visit): View
    {
        // Verify vendor access
        if ($visit->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $visit->load('patient.user', 'vendor.user');

        return view('vendor.scan.discount-summary', [
            'visit' => $visit,
            'patient' => $visit->patient,
            'vendor' => $visit->vendor,
        ]);
    }

    /**
     * Calculate discount before saving
     */
    public function calculateDiscount(Request $request): JsonResponse
    {
        try {
            $vendor = auth()->user()->vendor;
            $validated = $request->validate([
                'original_amount' => 'required|numeric|min:0',
            ]);

            $originalAmount = (float) $validated['original_amount'];
            $discountPercentage = (int) ($vendor->discount_percentage ?? 0);
            $discountAmount = round(($originalAmount * $discountPercentage) / 100, 2);
            $finalAmount = $originalAmount - $discountAmount;

            return response()->json([
                'success' => true,
                'original_amount' => $originalAmount,
                'discount_percentage' => $discountPercentage,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Generate discount receipt PDF
     */
    public function generateDiscountPDF(Visit $visit)
    {
        // Verify vendor access
        if ($visit->vendor_id !== auth()->user()->vendor->id) {
            abort(403);
        }

        $visit->load('patient.user', 'vendor.user');

        // Create PDF using mPDF
        try {
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 15,
                'margin_bottom' => 15,
            ]);

            $html = view('vendor.scan.receipt-pdf', [
                'visit' => $visit,
                'patient' => $visit->patient,
                'vendor' => $visit->vendor,
            ])->render();

            $mpdf->WriteHTML($html);

            $filename = 'Receipt_Visit_' . $visit->id . '_' . $visit->visited_at->format('YmdHis') . '.pdf';

            return $mpdf->Output($filename, 'D');
        } catch (\Exception $e) {
            \Log::error('PDF generation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate PDF');
        }
    }
}
