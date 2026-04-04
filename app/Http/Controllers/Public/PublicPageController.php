<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Vendor;
use App\Models\Visit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function home(): View
    {
        return view('public.home', [
            'stats' => [
                'vendors' => Vendor::query()->where('status', 'approved')->count(),
                'patients' => Patient::query()->count(),
                'visits' => Visit::query()->count(),
            ],
        ]);
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function pricing(): View
    {
        return view('public.pricing');
    }

    public function faq(): View
    {
        return view('public.faq');
    }

    public function vendors(): View
    {
        $vendors = Vendor::query()
            ->where('status', 'approved')
            ->latest()
            ->paginate(12);

        return view('public.vendors.index', compact('vendors'));
    }

    public function vendorShow(Vendor $vendor): View
    {
        abort_if($vendor->status !== 'approved', 404);

        return view('public.vendors.show', compact('vendor'));
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return back()->with('status', 'Thank you. We have received your message.');
    }
}

