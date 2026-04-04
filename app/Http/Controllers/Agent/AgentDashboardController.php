<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\View\View;

class AgentDashboardController extends Controller
{
    public function index(): View
    {
        $agent = request()->user()->agent;

        $patientsCount = Patient::query()->where('agent_id', $agent->id)->count();

        return view('agent.dashboard', [
            'patientsCount' => $patientsCount,
        ]);
    }
}
