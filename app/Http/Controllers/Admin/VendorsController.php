<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateVendorStatusRequest;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\UserWelcomeNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorsController extends Controller
{
    public function index(): View
    {
        $query = Vendor::query()->with('user');

        // Search by name, email, phone
        if (request('search')) {
            $search = '%' . request('search') . '%';
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('email', 'like', $search)
                                ->orWhere('phone', 'like', $search);
                  });
            });
        }

        // Filter by status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Filter by type
        if (request('type')) {
            $query->where('type', request('type'));
        }

        $vendors = $query->latest()->paginate(20);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function create(): View
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
            'type' => 'required|in:hospital,clinic,diagnostic,pharmacy',
            'address' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'password' => 'nullable|string|min:6',
        ]);

        // Generate password if not provided
        $password = $validated['password'] ?? Str::random(12);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => User::ROLE_VENDOR,
            'password' => bcrypt($password),
        ]);

        // Create vendor
        Vendor::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'address' => $validated['address'],
            'discount_percentage' => $validated['discount_percentage'],
            'status' => 'pending', // New vendors need approval
        ]);

        // Send welcome notification
        $user->notify(new UserWelcomeNotification(
            username: $user->email,
            password: $password,
            userType: 'Vendor'
        ));

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor registered successfully! Welcome notification sent.');
    }

    public function show(Vendor $vendor): View
    {
        $vendor->load('user');
        $visits = $vendor->visits()->with('patient.user')->latest()->paginate(10);
        return view('admin.vendors.show', compact('vendor', 'visits'));
    }

    public function edit(Vendor $vendor): View
    {
        $vendor->load('user');
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $vendor->user_id,
            'phone' => 'required|digits:10|unique:users,phone,' . $vendor->user_id,
            'type' => 'required|in:hospital,clinic,diagnostic,pharmacy',
            'address' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
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

        $vendor->user->update($updateData);

        // Update vendor
        $vendor->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'address' => $validated['address'],
            'discount_percentage' => $validated['discount_percentage'],
        ]);

        return redirect()->route('admin.vendors.show', $vendor)->with('success', 'Vendor updated successfully!');
    }

    public function updateStatus(UpdateVendorStatusRequest $request, Vendor $vendor): RedirectResponse
    {
        $vendor->update([
            'status' => $request->validated('status'),
        ]);

        return redirect()->route('admin.vendors.index')->with('status', 'Vendor status updated.');
    }

    public function destroy(Vendor $vendor): RedirectResponse
    {
        $vendor->user()->delete();
        $vendor->delete();

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully!');
    }
}
