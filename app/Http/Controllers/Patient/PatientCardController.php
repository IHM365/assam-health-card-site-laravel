<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PatientCardController extends Controller
{
    public function show(): View
    {
        $patient = request()->user()->patient;

        return view('patient.card.show', [
            'patient' => $patient,
            'verifyUrl' => route('public.verify.show', ['patient' => $patient->id]),
        ]);
    }
}
