<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\View\View;

class PatientVisitsController extends Controller
{
    public function index(): View
    {
        $patient = request()->user()->patient;

        $visits = Visit::query()
            ->with(['vendor', 'vendor.user', 'patient.user'])
            ->where('patient_id', $patient->id)
            ->latest('visited_at')
            ->paginate(20);

        return view('patient.visits.index', compact('visits'));
    }
}
