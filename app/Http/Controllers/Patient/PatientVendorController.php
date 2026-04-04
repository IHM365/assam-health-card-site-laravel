<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\View\View;

class PatientVendorController extends Controller
{
    public function index(): View
    {
        $query = Vendor::query();

        // Filter by type
        if (request('type')) {
            $query->where('type', request('type'));
        }

        // Search by name or address
        if (request('search')) {
            $search = '%' . request('search') . '%';
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('address', 'like', $search);
            });
        }

        // Only approved vendors
        $vendors = $query->where('status', 'approved')
            ->paginate(15);

        return view('patient.vendors.index', [
            'vendors' => $vendors,
        ]);
    }
}
