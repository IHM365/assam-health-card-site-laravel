<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\View\View;

class VerifyController extends Controller
{
    public function show(Patient $patient): View
    {
        $patient->load('agent.user');

        $vendor = auth()->check() && auth()->user()->role === \App\Models\User::ROLE_VENDOR
            ? auth()->user()->vendor
            : null;

        return view('public.verify.show', [
            'patient' => $patient,
            'vendor' => $vendor,
        ]);
    }
}
