<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreVisitRequest;
use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class VendorVerifyController extends Controller
{
    public function index(): View
    {
        return view('vendor.verify.index');
    }

    public function show(Patient $patient): View
    {
        $patient->load('agent.user');

        $vendor = request()->user()->vendor;

        return view('vendor.verify.show', [
            'patient' => $patient,
            'vendor' => $vendor,
        ]);
    }

    public function store(StoreVisitRequest $request): RedirectResponse
    {
        $vendor = $request->user()->vendor;
        $patient = Patient::query()->with('user')->findOrFail($request->validated('patient_id'));

        $original = $request->validated('original_amount');
        $discountPercent = (int) $vendor->discount_percentage;
        $discountAmount = 0.0;

        if ($original !== null) {
            $discountAmount = round(((float) $original) * ($discountPercent / 100), 2);
        }

        Visit::query()->create([
            'patient_id' => $patient->id,
            'vendor_id' => $vendor->id,
            'discount_percentage' => $discountPercent,
            'discount_amount' => $discountAmount,
            'original_amount' => $original,
            'visited_at' => Carbon::now(),
        ]);

        return redirect()->route('vendor.visits.index')->with('status', 'Visit marked.');
    }
}
