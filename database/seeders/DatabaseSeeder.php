<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Patient;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Visit;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@ahc.local',
            'phone' => '9999990001',
            'role' => User::ROLE_ADMIN,
            'password' => Hash::make('password'),
        ]);

        $agentUser = User::query()->create([
            'name' => 'Agent One',
            'email' => 'agent@ahc.local',
            'phone' => '9999990002',
            'role' => User::ROLE_AGENT,
            'password' => Hash::make('password'),
        ]);

        $agent = Agent::query()->create([
            'user_id' => $agentUser->id,
            'phone' => $agentUser->phone,
            'referral_code' => Str::upper(Str::random(8)),
        ]);

        $vendorUser = User::query()->create([
            'name' => 'Vendor One',
            'email' => 'vendor@ahc.local',
            'phone' => '9999990003',
            'role' => User::ROLE_VENDOR,
            'password' => Hash::make('password'),
        ]);

        $vendor = Vendor::query()->create([
            'user_id' => $vendorUser->id,
            'name' => 'Demo Clinic',
            'type' => 'clinic',
            'address' => 'Guwahati, Assam',
            'discount_percentage' => 15,
            'status' => 'approved',
        ]);

        $patientUser = User::query()->create([
            'name' => 'Patient One',
            'email' => 'patient@ahc.local',
            'phone' => '9999990004',
            'role' => User::ROLE_PATIENT,
            'password' => Hash::make('password'),
        ]);

        $patient = Patient::query()->create([
            'user_id' => $patientUser->id,
            'name' => $patientUser->name,
            'phone' => $patientUser->phone,
            'address' => 'Assam',
            'agent_id' => $agent->id,
            'status' => 'active',
            'card_type' => 'individual',
        ]);

        // Create test visits
        Visit::query()->create([
            'patient_id' => $patient->id,
            'vendor_id' => $vendor->id,
            'original_amount' => 1000,
            'discount_percentage' => 15,
            'discount_amount' => 150,
            'service_type' => 'General Consultation',
            'notes' => 'Regular checkup',
            'verification_method' => 'qr',
            'visited_at' => now()->subDays(2),
        ]);

        Visit::query()->create([
            'patient_id' => $patient->id,
            'vendor_id' => $vendor->id,
            'original_amount' => 2500,
            'discount_percentage' => 15,
            'discount_amount' => 375,
            'service_type' => 'Blood Test',
            'notes' => 'Complete blood work',
            'verification_method' => 'mobile',
            'visited_at' => now()->subDays(1),
        ]);

        Visit::query()->create([
            'patient_id' => $patient->id,
            'vendor_id' => $vendor->id,
            'original_amount' => 5000,
            'discount_percentage' => 15,
            'discount_amount' => 750,
            'service_type' => 'X-Ray Consultation',
            'notes' => 'Chest X-Ray followup',
            'verification_method' => 'qr',
            'visited_at' => now(),
        ]);

        // Seed additional vendors
        $this->call(VendorSeeder::class);
    }
}
