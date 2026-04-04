<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\View\View;

class PatientDashboardController extends Controller
{
    public function index(): View
    {
        $patient = request()->user()->patient;

        $totalVisits = Visit::query()->where('patient_id', $patient->id)->count();
        $totalSavings = (float) Visit::query()->where('patient_id', $patient->id)->sum('discount_amount');
        
        $visits = Visit::query()
            ->with(['vendor', 'vendor.user', 'patient.user'])
            ->where('patient_id', $patient->id)
            ->latest('visited_at')
            ->get();

        return view('patient.dashboard', [
            'totalVisits' => $totalVisits,
            'totalSavings' => $totalSavings,
            'visits' => $visits,
            'patient' => $patient,
        ]);
    }
}
