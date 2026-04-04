<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use App\Notifications\UserWelcomeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AgentsController extends Controller
{
    public function index(): View
    {
        $query = Agent::query()->with('user');

        // Search by name, phone, or referral code
        if (request('search')) {
            $search = '%' . request('search') . '%';
            $query->where(function($q) use ($search) {
                $q->where('referral_code', 'like', $search)
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', $search)
                                ->orWhere('phone', 'like', $search);
                  });
            });
        }

        $agents = $query->latest()->paginate(30);

        return view('admin.agents.index', compact('agents'));
    }

    public function create(): View
    {
        return view('admin.agents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
            'password' => 'nullable|string|min:6',
        ]);

        // Generate password if not provided
        $password = $validated['password'] ?? Str::random(12);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => User::ROLE_AGENT,
            'password' => bcrypt($password),
        ]);

        // Create agent with referral code
        Agent::create([
            'user_id' => $user->id,
            'phone' => $user->phone,
            'referral_code' => Str::upper(Str::random(8)),
        ]);

        // Send welcome notification
        $user->notify(new UserWelcomeNotification(
            username: $user->email,
            password: $password,
            userType: 'Agent'
        ));

        return redirect()->route('admin.agents.index')->with('success', 'Agent registered successfully! Welcome notification sent.');
    }

    public function show(Agent $agent): View
    {
        $agent->load('user');
        $patients = $agent->patients()->with('user')->latest()->paginate(10);
        return view('admin.agents.show', compact('agent', 'patients'));
    }

    public function edit(Agent $agent): View
    {
        $agent->load('user');
        return view('admin.agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $agent->user_id,
            'phone' => 'required|digits:10|unique:users,phone,' . $agent->user_id,
            'password' => 'nullable|string|min:6',
        ]);

        // Update user
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        $agent->user->update($updateData);

        // Update agent phone
        $agent->update(['phone' => $validated['phone']]);

        return redirect()->route('admin.agents.show', $agent)->with('success', 'Agent updated successfully!');
    }

    public function destroy(Agent $agent): RedirectResponse
    {
        $agent->user()->delete();
        $agent->delete();

        return redirect()->route('admin.agents.index')->with('success', 'Agent deleted successfully!');
    }
}
