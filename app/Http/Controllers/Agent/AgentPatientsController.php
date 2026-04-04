<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\StorePatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AgentPatientsController extends Controller
{
    public function index(): View
    {
        $agent = request()->user()->agent;

        $patients = Patient::query()
            ->with('user')
            ->where('agent_id', $agent->id)
            ->latest()
            ->paginate(20);

        return view('agent.patients.index', compact('patients'));
    }

    public function create(): View
    {
        return view('agent.patients.create');
    }

    public function store(StorePatientRequest $request): RedirectResponse
    {
        $agent = $request->user()->agent;

        $data = $request->validated();

        $email = $data['email'] ?? null;
        if (! $email) {
            $base = 'p'.preg_replace('/\D+/', '', (string) $data['phone']);
            $email = $base.'@ahc.local';
            while (User::query()->where('email', $email)->exists()) {
                $email = $base.'+'.Str::lower(Str::random(4)).'@ahc.local';
            }
        }

        DB::transaction(function () use ($agent, $data, $email) {
            $user = User::query()->create([
                'name' => $data['name'],
                'email' => $email,
                'phone' => $data['phone'],
                'role' => User::ROLE_PATIENT,
                'password' => $data['password'],
            ]);

            Patient::query()->create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'] ?? null,
                'agent_id' => $agent->id,
                'status' => 'active',
            ]);
        });

        return redirect()->route('agent.patients.index')->with('status', 'Patient registered.');
    }
}
