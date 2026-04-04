<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'Apollo Hospitals Guwahati',
                'type' => 'hospital',
                'address' => 'GS Road, Guwahati, Assam 781001',
                'discount_percentage' => 35,
                'status' => 'approved',
                'email' => 'apollo-guwahati@ahc.local',
            ],
            [
                'name' => 'SRL Diagnostics',
                'type' => 'diagnostic',
                'address' => 'Dispur, Guwahati, Assam 781006',
                'discount_percentage' => 40,
                'status' => 'approved',
                'email' => 'srl-diagnostics@ahc.local',
            ],
            [
                'name' => 'Medlife Pharmacy',
                'type' => 'pharmacy',
                'address' => 'Beltola, Guwahati, Assam 781028',
                'discount_percentage' => 20,
                'status' => 'approved',
                'email' => 'medlife-pharmacy@ahc.local',
            ],
            [
                'name' => 'Dr. Sharma\'s Clinic',
                'type' => 'clinic',
                'address' => 'Paltan Bazar, Guwahati, Assam 781008',
                'discount_percentage' => 30,
                'status' => 'approved',
                'email' => 'sharma-clinic@ahc.local',
            ],
            [
                'name' => 'Care Diagnostics',
                'type' => 'lab',
                'address' => 'Uzanbazar, Guwahati, Assam 781001',
                'discount_percentage' => 38,
                'status' => 'approved',
                'email' => 'care-diagnostics@ahc.local',
            ],
            [
                'name' => 'Apollo Pharmacy',
                'type' => 'pharmacy',
                'address' => 'Kamrup, Guwahati, Assam 781001',
                'discount_percentage' => 25,
                'status' => 'approved',
                'email' => 'apollo-pharmacy@ahc.local',
            ],
            [
                'name' => 'Max Hospitals',
                'type' => 'hospital',
                'address' => 'Lakhanpal Township, Guwahati, Assam 781037',
                'discount_percentage' => 32,
                'status' => 'approved',
                'email' => 'max-hospitals@ahc.local',
            ],
            [
                'name' => 'Path Lab & Diagnostics',
                'type' => 'lab',
                'address' => 'Bhangagarh, Guwahati, Assam 781005',
                'discount_percentage' => 35,
                'status' => 'approved',
                'email' => 'pathlab-diagnostics@ahc.local',
            ],
            [
                'name' => 'Narayana Heart Centre',
                'type' => 'hospital',
                'address' => 'Guwahati, Assam 781007',
                'discount_percentage' => 40,
                'status' => 'approved',
                'email' => 'narayana-heart@ahc.local',
            ],
            [
                'name' => 'Prime Clinic & Pharmacy',
                'type' => 'clinic',
                'address' => 'Pan Bazar, Guwahati, Assam 781001',
                'discount_percentage' => 28,
                'status' => 'approved',
                'email' => 'prime-clinic@ahc.local',
            ],
            [
                'name' => 'Indraprastha Medical Center',
                'type' => 'hospital',
                'address' => 'Rehabari, Guwahati, Assam 781008',
                'discount_percentage' => 33,
                'status' => 'approved',
                'email' => 'indraprastha-medical@ahc.local',
            ],
            [
                'name' => 'Lifeline Pharmacy',
                'type' => 'pharmacy',
                'address' => 'Purana Guwahati, Guwahati, Assam 781037',
                'discount_percentage' => 22,
                'status' => 'approved',
                'email' => 'lifeline-pharmacy@ahc.local',
            ],
        ];

        foreach ($vendors as $vendor) {
            $vendorData = $vendor;
            $email = $vendorData['email'];
            $name = $vendorData['name'];
            unset($vendorData['email']);

            // Create user if doesn't exist
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'phone' => '9999990' . rand(1000, 9999),
                    'role' => User::ROLE_VENDOR,
                    'password' => 'password',
                ]
            );
            
            // Create vendor if doesn't exist
            Vendor::firstOrCreate(
                ['user_id' => $user->id],
                ['name' => $name] + $vendorData
            );
        }
    }
}

