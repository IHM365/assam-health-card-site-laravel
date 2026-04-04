<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AgentsController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\VendorsController;
use App\Http\Controllers\Admin\VisitsController;
use App\Http\Controllers\Agent\AgentDashboardController;
use App\Http\Controllers\Agent\AgentPatientsController;
use App\Http\Controllers\Patient\PatientCardController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\Patient\PatientVendorController;
use App\Http\Controllers\Patient\PatientVisitsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\CardController;
use App\Http\Controllers\Public\PublicPageController;
use App\Http\Controllers\Public\VerifyController;
use App\Http\Controllers\Vendor\VendorBillController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorPaymentController;
use App\Http\Controllers\Vendor\VendorReportController;
use App\Http\Controllers\Vendor\VendorScanController;
use App\Http\Controllers\Vendor\VendorVerifyController;
use App\Http\Controllers\Vendor\VendorVisitsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPageController::class, 'home'])->name('public.home');
Route::get('/about-us', [PublicPageController::class, 'about'])->name('public.about');
Route::get('/pricing', [PublicPageController::class, 'pricing'])->name('public.pricing');
Route::get('/faq', [PublicPageController::class, 'faq'])->name('public.faq');
Route::get('/vendors', [PublicPageController::class, 'vendors'])->name('public.vendors');
Route::get('/vendors/{vendor}', [PublicPageController::class, 'vendorShow'])->name('public.vendors.show');
Route::get('/contact', [PublicPageController::class, 'contact'])->name('public.contact');
Route::post('/contact', [PublicPageController::class, 'submitContact'])->name('public.contact.submit');

Route::get('/dashboard', function () {
    $user = request()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        \App\Models\User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
        \App\Models\User::ROLE_AGENT => redirect()->route('agent.dashboard'),
        \App\Models\User::ROLE_VENDOR => redirect()->route('vendor.dashboard'),
        default => redirect()->route('patient.dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

// Public (Phase 1)
Route::view('/apply-agent', 'public.apply-agent')->name('public.apply-agent');
Route::view('/apply-vendor', 'public.apply-vendor')->name('public.apply-vendor');
Route::get('/card/{patient}', [CardController::class, 'show'])->name('public.card.show');
Route::get('/verify/{patient}', [VerifyController::class, 'show'])->name('public.verify.show');
Route::get('/patient/login', fn () => redirect()->route('login'))->name('patient.login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role dashboards (Phase 1 placeholders; controllers come next)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('patients', PatientsController::class);
    Route::patch('/patients/{patient}/status', [PatientsController::class, 'updateStatus'])->name('patients.status');
    Route::get('/patients/{patient}/card', [PatientsController::class, 'downloadCard'])->name('patients.card');
    Route::get('/patients/{patient}/acknowledgement', [PatientsController::class, 'downloadAcknowledgement'])->name('patients.acknowledgement');
    Route::resource('agents', AgentsController::class);
    Route::resource('vendors', VendorsController::class);
    Route::patch('/vendors/{vendor}/status', [VendorsController::class, 'updateStatus'])->name('vendors.status');
    Route::resource('visits', VisitsController::class);
    Route::get('/visits/export/csv', [VisitsController::class, 'export'])->name('visits.export');
});

Route::middleware(['auth', 'role:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/patients', [AgentPatientsController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [AgentPatientsController::class, 'create'])->name('patients.create');
    Route::post('/patients', [AgentPatientsController::class, 'store'])->name('patients.store');
});

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/verify', [VendorVerifyController::class, 'index'])->name('verify.index');
    Route::get('/verify/{patient}', [VendorVerifyController::class, 'show'])->name('verify.show');
    Route::post('/visits', [VendorVerifyController::class, 'store'])->name('visits.store');
    Route::get('/visits', [VendorVisitsController::class, 'index'])->name('visits.index');
    
    // Scan and verification routes
    Route::get('/scan', [VendorScanController::class, 'index'])->name('scan.index');
    Route::post('/scan/verify-qr', [VendorScanController::class, 'verifyByQr'])->name('scan.verify-qr');
    Route::post('/scan/verify-mobile', [VendorScanController::class, 'verifyByMobile'])->name('scan.verify-mobile');
    Route::post('/scan/calculate', [VendorScanController::class, 'calculateDiscount'])->name('scan.calculate');
    Route::post('/scan/store', [VendorScanController::class, 'storeDiscount'])->name('scan.store');
    Route::get('/scan/summary/{visit}', [VendorScanController::class, 'showSummary'])->name('scan.summary');
    Route::get('/scan/receipt/{visit}', [VendorScanController::class, 'generateDiscountPDF'])->name('scan.receipt');
    
    // Bill upload, reports, and payments
    Route::get('/bills', [VendorBillController::class, 'index'])->name('bills.index');
    Route::post('/bills/upload', [VendorBillController::class, 'upload'])->name('bills.upload');
    Route::get('/reports', [VendorReportController::class, 'monthlyReport'])->name('reports.monthly');
    Route::get('/payments', [VendorPaymentController::class, 'paymentHistory'])->name('payments.history');
});

Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/visits', [PatientVisitsController::class, 'index'])->name('visits.index');
    Route::get('/card', [PatientCardController::class, 'show'])->name('card.show');
    Route::get('/vendors', [PatientVendorController::class, 'index'])->name('vendors.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
