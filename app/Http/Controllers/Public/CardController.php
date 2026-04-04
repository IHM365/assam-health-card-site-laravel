<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\View\View;

class CardController extends Controller
{
    public function show(Patient $patient): View
    {
        return view('public.card.show', [
            'patient' => $patient,
            'verifyUrl' => route('public.verify.show', ['patient' => $patient->id]),
        ]);
    }
}
