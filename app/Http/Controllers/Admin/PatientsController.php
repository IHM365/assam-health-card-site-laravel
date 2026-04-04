<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Patient;
use App\Models\User;
use App\Notifications\UserWelcomeNotification;
use App\Services\CardGenerationService;
use App\Services\AcknowledgementLetterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PatientsController extends Controller
{
    public function index(): View
    {
        $query = Patient::query()->with(['user', 'agent.user']);

        // Search by name, phone, or card ID
        if (request('search')) {
            $search = '%' . request('search') . '%';
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('phone', 'like', $search)
                  ->orWhere('id', 'like', $search);
            });
        }

        // Filter by status
        if (request('status')) {
            $query->where('status', request('status'));
        }

        $patients = $query->latest()->paginate(30);

        return view('admin.patients.index', compact('patients'));
    }

    public function create(): View
    {
        $agents = Agent::with('user')->get();
        return view('admin.patients.create', compact('agents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
            'address' => 'required|string|max:255',
            'address_proof_type' => 'nullable|in:aadhar,passport,driving_license,utility_bill,rental_agreement,other',
            'address_proof_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'password' => 'nullable|string|min:6',
            'agent_id' => 'nullable|exists:agents,id',
            'status' => 'required|in:active,inactive',
            'card_validity_date' => 'nullable|date',
            'profile_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'card_type' => 'required|in:individual,family',
        ]);

        // Handle profile image upload
        $profileImagePath = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $profileImagePath = $file->storeAs('profiles', $filename, 'public');
        }

        // Handle address proof file upload
        $addressProofPath = null;
        if ($request->hasFile('address_proof_file')) {
            $file = $request->file('address_proof_file');
            $filename = 'proof_' . time() . '.' . $file->getClientOriginalExtension();
            $addressProofPath = $file->storeAs('proofs', $filename, 'public');
        }

        // Generate password if not provided
        $password = $validated['password'] ?? Str::random(12);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => User::ROLE_PATIENT,
            'password' => bcrypt($password),
            'profile_image' => $profileImagePath ? '/storage/' . $profileImagePath : null,
            'address' => $validated['address'],
        ]);

        // Create patient
        $patient = Patient::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'address_proof_type' => $validated['address_proof_type'] ?? null,
            'address_proof_file' => $addressProofPath ? '/storage/' . $addressProofPath : null,
            'agent_id' => $validated['agent_id'],
            'status' => 'active', // Default to active
            'card_type' => $validated['card_type'], // Use form value
            'profile_image' => $profileImagePath ? '/storage/' . $profileImagePath : null,
            'card_validity_date' => $validated['card_validity_date'] ?? now()->addYears(1), // Default 1 year
        ]);

        // Generate card and acknowledgement letter
        try {
            $cardService = new CardGenerationService();
            $letterService = new AcknowledgementLetterService();
            
            $cardService->generateCard($patient);
            $letterService->generateLetter($user);
            
            $cardGenerated = 'Card and acknowledgement letter generated successfully!';
        } catch (\Exception $e) {
            \Log::error('Card/Letter generation failed', ['error' => $e->getMessage()]);
            $cardGenerated = '(Note: Card/letter generation completed with limitations)';
        }

        // Send welcome notification (email, SMS, WhatsApp)
        $user->notify(new UserWelcomeNotification(
            username: $user->email,
            password: $password,
            userType: 'Patient'
        ));

        return redirect()->route('admin.patients.index')->with('success', "Patient registered successfully! {$cardGenerated} Welcome email, SMS, and WhatsApp message sent.");
    }

    public function show(Patient $patient): View
    {
        $patient->load(['user', 'agent.user']);
        $visits = $patient->visits()->with('vendor.user')->latest()->get();
        return view('admin.patients.show', compact('patient', 'visits'));
    }

    public function edit(Patient $patient): View
    {
        $agents = Agent::with('user')->get();
        $patient->load('user');
        return view('admin.patients.edit', compact('patient', 'agents'));
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'phone' => 'required|digits:10|unique:users,phone,' . $patient->user_id,
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'agent_id' => 'nullable|exists:agents,id',
            'status' => 'required|in:active,inactive',
            'card_type' => 'required|in:individual,family',
            'address_proof_type' => 'nullable|in:aadhar,passport,driving_license,utility_bill,rental_agreement,other',
            'address_proof_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'profile_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'card_validity_date' => 'nullable|date',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
            $profileImagePath = $file->storeAs('profiles', $filename, 'public');
            $patient->profile_image = '/storage/' . $profileImagePath;
        }

        // Handle address proof file upload
        if ($request->hasFile('address_proof_file')) {
            $file = $request->file('address_proof_file');
            $filename = 'proof_' . time() . '.' . $file->getClientOriginalExtension();
            $addressProofPath = $file->storeAs('proofs', $filename, 'public');
            $patient->address_proof_file = '/storage/' . $addressProofPath;
        }

        // Update user
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ];

        // Update password if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        $patient->user->update($updateData);

        // Update patient
        $patient->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'agent_id' => $validated['agent_id'],
            'status' => $validated['status'],
            'card_type' => $validated['card_type'],
            'address_proof_type' => $validated['address_proof_type'] ?? $patient->address_proof_type,
            'card_validity_date' => $validated['card_validity_date'] ?? $patient->card_validity_date,
        ]);

        return redirect()->route('admin.patients.show', $patient)->with('success', 'Patient updated successfully!');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        $patient->user()->delete();
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully!');
    }

    public function downloadCard(Patient $patient): BinaryFileResponse|RedirectResponse
    {
        try {
            $cardService = new CardGenerationService();
            $cardPath = $cardService->generateCard($patient);
            $fullPath = public_path($cardPath);

            if (!file_exists($fullPath)) {
                abort(404, 'Card not found');
            }

            $preview = request()->query('preview', false);
            
            if ($preview) {
                // Return with inline disposition for preview
                return response()->file($fullPath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="Assam_Health_Card_' . $patient->id . '.pdf"',
                ]);
            } else {
                // Return with attachment disposition for download
                return response()->download($fullPath, 'Assam_Health_Card_' . $patient->id . '.pdf');
            }
        } catch (\Exception $e) {
            \Log::error('Card download failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate card: ' . $e->getMessage());
        }
    }

    public function downloadAcknowledgement(Patient $patient): BinaryFileResponse|RedirectResponse
    {
        try {
            $letterService = new AcknowledgementLetterService();
            $letterPath = $letterService->generateLetter($patient->user);
            $fullPath = public_path($letterPath);

            if (!file_exists($fullPath)) {
                abort(404, 'Acknowledgement letter not found');
            }

            return response()->download($fullPath, 'Acknowledgement_' . $patient->user->name . '.pdf');
        } catch (\Exception $e) {
            \Log::error('Acknowledgement download failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to generate acknowledgement: ' . $e->getMessage());
        }
    }

    public function updateStatus(Patient $patient): \Illuminate\Http\JsonResponse
    {
        try {
            $newStatus = $patient->status === 'active' ? 'inactive' : 'active';
            $patient->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'status' => $newStatus,
                'message' => 'Status updated to ' . ucfirst($newStatus),
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ], 500);
        }
    }
}
