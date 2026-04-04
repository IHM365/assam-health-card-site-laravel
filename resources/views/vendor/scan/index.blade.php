@extends('vendor.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Verify Patient Card</h1>
        <p class="text-gray-600 mt-2">Scan QR code or enter mobile number to get started</p>
    </div>

    <!-- Main Container -->
    <div id="initial-screen" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Start Scanning Option -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl border-2 border-blue-200 p-8 shadow-lg hover:shadow-xl transition-all cursor-pointer transform hover:scale-105" onclick="startScanning()">
            <div class="flex flex-col items-center text-center h-full justify-center py-8">
                <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center mb-6 animate-pulse">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Scan QR Code</h2>
                <p class="text-gray-700 mb-6">Point your camera at the patient's health card to scan the QR code</p>
                <button class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-bold rounded-full hover:bg-blue-700 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path></svg>
                    Start Camera
                </button>
            </div>
        </div>

        <!-- Mobile Number Option -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl border-2 border-green-200 p-8 shadow-lg hover:shadow-xl transition-all cursor-pointer transform hover:scale-105" onclick="switchToMobile()">
            <div class="flex flex-col items-center text-center h-full justify-center py-8">
                <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948.684l1.498 7.491a1 1 0 00.502.756l2.048 1.029a2 2 0 002.063-.064l2.015-1.993a2 2 0 012.541.411l1.08 1.577a1 1 0 00.85.37h.822a2 2 0 012 2v2a2 2 0 01-2 2h-2.468c-1.119 0-2.753-.36-4.514-2.074C7.612 20.565 4 17.026 4 12V5z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Enter Mobile Number</h2>
                <p class="text-gray-700 mb-6">Search patient using their registered mobile number</p>
                <button class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.766.68 1.553.973 2.348.284.797.561 1.6.78 2.396l1.559.779a1 1 0 01.54 1.06l-.74 4.435a1 1 0 01-.986.836H3a1 1 0 01-1-1V3z"></path></svg>
                    Enter Number
                </button>
            </div>
        </div>
    </div>

    <!-- Scanning Screen (Hidden Initially) -->
    <div id="scanning-screen" class="hidden space-y-6">
        <!-- Camera View -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">QR Code Scanner</h2>
                <button onclick="stopScanning()" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Close
                </button>
            </div>

            <!-- QR Reader Container -->
            <div id="qr-reader" class="w-full rounded-lg bg-black" style="height: 650px;"></div>

            <!-- Manual Input Fallback -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-3">Camera not working? Enter patient ID manually:</p>
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        id="qr-input" 
                        placeholder="Enter or paste patient ID..." 
                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <button onclick="verifyPatientIdFromInput()" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                        Verify
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Number Screen (Hidden Initially) -->
    <div id="mobile-screen" class="hidden">
        <div class="max-w-md mx-auto bg-white rounded-2xl border border-gray-200 p-8 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Enter Mobile Number</h2>
                <button onclick="backToInitial()" class="inline-flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form onsubmit="verifyByMobile(event)" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Patient Mobile Number</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-600 font-semibold">+91</span>
                        <input 
                            type="tel" 
                            id="mobile-input" 
                            placeholder="Enter 10-digit number"
                            pattern="[0-9]{10}"
                            inputmode="numeric"
                            required
                            class="w-full pl-14 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-lg"
                        />
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Format: 10 digits without country code</p>
                </div>

                <button 
                    type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-lg hover:shadow-lg transition"
                >
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Verify Patient
                </button>
            </form>
        </div>
    </div>

    <!-- Patient Details Panel -->
    <div id="patient-panel" class="hidden max-w-2xl mx-auto bg-white rounded-2xl border-2 border-emerald-200 p-8 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">✓ Patient Verification</h2>
            <button onclick="resetScan()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Start Over
            </button>
        </div>

        <div class="space-y-4">
            <!-- Profile Section -->
            <div class="flex items-center gap-4 pb-4 border-b border-gray-200">
                <div>
                    <img id="patient-image" src="" alt="Patient" class="w-16 h-16 rounded-full border-4 border-blue-200 object-cover hidden" />
                    <div id="patient-image-fallback" class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center hidden">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase">Patient Name</p>
                    <p id="patient-name" class="text-xl font-bold text-gray-900">-</p>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Patient ID</p>
                    <p id="patient-id" class="text-lg font-bold text-gray-900 mt-1">-</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Phone</p>
                    <p id="patient-phone" class="text-lg font-bold text-gray-900 mt-1">-</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs font-semibold text-blue-600 uppercase">Card Type</p>
                    <div id="card-type-badge" class="text-lg font-bold text-blue-700 mt-1">-</div>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <p class="text-xs font-semibold text-green-600 uppercase">Status</p>
                    <div id="status-badge" class="text-lg font-bold text-green-700 mt-1">Active</div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <button onclick="proceedToDiscount()" class="w-full mt-6 px-6 py-4 bg-gradient-to-r from-blue-600 to-emerald-600 text-white font-bold rounded-lg hover:shadow-lg transition flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Continue to Discount
        </button>
    </div>

    <!-- Error Panel -->
    <div id="error-panel" class="hidden max-w-md mx-auto bg-red-50 border-2 border-red-200 rounded-lg p-6 shadow">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div class="flex-1">
                <h3 class="font-bold text-red-900">Verification Failed</h3>
                <p id="error-message" class="text-sm text-red-700 mt-2">-</p>
            </div>
        </div>
        <button onclick="backToInitial()" class="w-full mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            Try Again
        </button>
    </div>
</div>

@include('vendor.scan.discount-form')

<!-- QR Code Library with Better Camera Support -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>

<script>
let currentPatient = null;
let qrScanner = null;
let isScannerActive = false;
let verificationMethod = 'qr';

function startScanning() {
    document.getElementById('initial-screen').classList.add('hidden');
    document.getElementById('scanning-screen').classList.remove('hidden');
    document.getElementById('mobile-screen').classList.add('hidden');
    document.getElementById('patient-panel').classList.add('hidden');
    document.getElementById('error-panel').classList.add('hidden');
    initQRScanner();
}

function initQRScanner() {
    if (isScannerActive) return;
    try {
        // Check camera permission first
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment", width: { ideal: 1280 }, height: { ideal: 720 } } })
                .then(stream => {
                    // Permission granted, close the stream and start scanner
                    stream.getTracks().forEach(track => track.stop());
                    
                    const html5QrCode = new Html5Qrcode("qr-reader", { formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE] });
                    qrScanner = html5QrCode;
                    
                    html5QrCode.start(
                        { facingMode: "environment" },
                        { fps: 30, qrbox: { width: 350, height: 350 }, aspectRatio: 1.0, disableFlip: false, showZoomButton: true },
                        (decodedText) => { handleQRSuccess(decodedText, html5QrCode); },
                        (error) => {}
                    ).catch(err => {
                        console.error('Scanner error:', err);
                        showError('Camera connection error: ' + (err.message || 'Unable to start camera'));
                    });
                    isScannerActive = true;
                })
                .catch(err => {
                    let errorMsg = 'Unable to access camera. ';
                    if (err.name === 'NotAllowedError') {
                        errorMsg += 'Camera permission was denied. Please allow camera access in your browser settings and try again.';
                    } else if (err.name === 'NotFoundError') {
                        errorMsg += 'No camera device found on this device.';
                    } else if (err.name === 'NotReadableError') {
                        errorMsg += 'Camera is already in use by another application. Please close other apps using camera.';
                    } else if (err.name === 'SecurityError') {
                        errorMsg += 'Camera access is blocked by security policy. Ensure you\'re using HTTPS and not in an iframe.';
                    } else if (err.name === 'OverconstrainedError') {
                        errorMsg += 'No camera matches your requirements. Try a different device.';
                    } else {
                        errorMsg += err.message || 'Please try entering the mobile number instead.';
                    }
                    showError(errorMsg);
                    console.error('Camera permission error:', err);
                });
        } else {
            showError('Camera not supported on this device or browser. Please enter the mobile number instead.');
        }
    } catch (error) {
        showError('Camera initialization failed: ' + error.message);
        console.error('Initialization error:', error);
    }
}

function handleQRSuccess(decodedText, scanner) {
    scanner.stop().then(() => {
        isScannerActive = false;
        const patientId = extractPatientId(decodedText);
        if (patientId) verifyByQRCode(patientId);
    });
}

function extractPatientId(qrData) {
    const patterns = [/\/verify\/(\d+)/, /patient[_-]?id[:\s]*(\d+)/i, /^(\d+)$/, /(\d+)/];
    for (const pattern of patterns) {
        const match = qrData.match(pattern);
        if (match && match[1]) return match[1];
    }
    return null;
}

async function verifyByQRCode(patientId) {
    try {
        const response = await fetch('{{ route("vendor.scan.verify-qr") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ patient_id: patientId })
        });
        const data = await response.json();
        if (data.success) {
            verificationMethod = 'qr';
            currentPatient = data.patient;
            displayPatientDetails(data);
            document.getElementById('scanning-screen').classList.add('hidden');
            document.getElementById('patient-panel').classList.remove('hidden');
            document.getElementById('error-panel').classList.add('hidden');
        } else {
            showError(data.message || 'Patient not found');
        }
    } catch (error) {
        showError('Failed to verify patient: ' + error.message);
    }
}

async function verifyByMobile(event) {
    event.preventDefault();
    const phone = document.getElementById('mobile-input').value;
    try {
        const response = await fetch('{{ route("vendor.scan.verify-mobile") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ phone })
        });
        const data = await response.json();
        if (data.success) {
            verificationMethod = 'mobile';
            currentPatient = data.patient;
            displayPatientDetails(data);
            document.getElementById('scanning-screen').classList.add('hidden');
            document.getElementById('mobile-screen').classList.add('hidden');
            document.getElementById('patient-panel').classList.remove('hidden');
            document.getElementById('error-panel').classList.add('hidden');
        } else {
            showError(data.message || 'Patient not found');
        }
    } catch (error) {
        showError('Failed to verify patient: ' + error.message);
    }
}

function displayPatientDetails(data) {
    const patient = data.patient;
    if (patient.profile_image) {
        document.getElementById('patient-image').src = patient.profile_image;
        document.getElementById('patient-image').classList.remove('hidden');
        document.getElementById('patient-image-fallback').classList.add('hidden');
    } else {
        document.getElementById('patient-image').classList.add('hidden');
        document.getElementById('patient-image-fallback').classList.remove('hidden');
    }
    document.getElementById('patient-name').textContent = patient.name;
    document.getElementById('patient-id').textContent = '#' + patient.id;
    document.getElementById('patient-phone').textContent = patient.phone;
    const badgeEl = document.getElementById('card-type-badge');
    badgeEl.textContent = patient.card_type === 'family' ? '👥 Family Card' : '👤 Individual';
}

function showError(message) {
    document.getElementById('error-message').textContent = message;
    document.getElementById('error-panel').classList.remove('hidden');
}

function stopScanning() {
    if (qrScanner && isScannerActive) {
        qrScanner.stop().then(() => {
            isScannerActive = false;
            backToInitial();
        });
    } else {
        backToInitial();
    }
}

function switchToMobile() {
    if (qrScanner && isScannerActive) {
        qrScanner.stop().then(() => {
            isScannerActive = false;
            document.getElementById('initial-screen').classList.add('hidden');
            document.getElementById('scanning-screen').classList.add('hidden');
            document.getElementById('mobile-screen').classList.remove('hidden');
            document.getElementById('mobile-input').focus();
        });
    } else {
        document.getElementById('initial-screen').classList.add('hidden');
        document.getElementById('scanning-screen').classList.add('hidden');
        document.getElementById('mobile-screen').classList.remove('hidden');
        document.getElementById('mobile-input').focus();
    }
}

function backToInitial() {
    if (qrScanner && isScannerActive) {
        qrScanner.stop().then(() => {
            isScannerActive = false;
            showInitialScreen();
        });
    } else {
        showInitialScreen();
    }
}

function showInitialScreen() {
    document.getElementById('initial-screen').classList.remove('hidden');
    document.getElementById('scanning-screen').classList.add('hidden');
    document.getElementById('mobile-screen').classList.add('hidden');
    document.getElementById('patient-panel').classList.add('hidden');
    document.getElementById('error-panel').classList.add('hidden');
    document.getElementById('mobile-input').value = '';
}

async function verifyPatientIdFromInput() {
    const patientId = document.getElementById('qr-input').value.trim();
    if (!patientId) {
        showError('Please enter a patient ID');
        return;
    }
    if (qrScanner && isScannerActive) {
        qrScanner.stop().then(() => {
            isScannerActive = false;
            verifyByQRCode(patientId);
        });
    } else {
        verifyByQRCode(patientId);
    }
}

function proceedToDiscount() {
    if (currentPatient) {
        document.getElementById('patient-id-input').value = currentPatient.id;
        document.getElementById('verification-method-input').value = verificationMethod;
        document.getElementById('discount-modal').classList.remove('hidden');
    }
}

function resetScan() {
    currentPatient = null;
    showInitialScreen();
}
</script>
@endsection
