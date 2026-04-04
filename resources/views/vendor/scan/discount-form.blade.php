<!-- Discount Modal -->
<div id="discount-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-gray-200 max-w-2xl w-full max-h-96 overflow-y-auto shadow-xl">
        <!-- Header -->
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-green-600 text-white px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold">Add Discount Details</h2>
                <button onclick="closeDiscountForm()" class="text-white hover:bg-white hover:bg-opacity-20 p-1 rounded">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
            </div>
        </div>

        <!-- Form -->
        <form id="discount-form" onsubmit="submitDiscount(event)" class="p-6 space-y-4">
            @csrf
            
            <input type="hidden" id="patient-id-input" name="patient_id" />
            <input type="hidden" id="verification-method-input" name="verification_method" value="qr" />

            <!-- Service Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <x-heroicon-s-briefcase class="w-4 h-4 inline mr-2" />
                    Service Type (Optional)
                </label>
                <input
                    type="text"
                    name="service_type"
                    placeholder="e.g., Consultation, Blood Test, X-Ray"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            <!-- Original Amount -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <x-heroicon-s-banknotes class="w-4 h-4 inline mr-2" />
                    Original Amount
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-gray-600 font-semibold">₹</span>
                    <input
                        type="number"
                        id="original-amount"
                        name="original_amount"
                        placeholder="100"
                        step="0.01"
                        min="0"
                        required
                        class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="calculateDiscount()"
                    />
                </div>
            </div>

            <!-- Discount Display -->
            <div id="discount-display" class="hidden p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 font-semibold">Discount Percentage:</span>
                    <span id="discount-percent" class="text-lg font-bold text-green-600">0%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 font-semibold">Discount Amount:</span>
                    <span id="discount-amount" class="text-lg font-bold text-green-600">₹0</span>
                </div>
                <div class="border-t border-gray-200 pt-2 mt-2 flex items-center justify-between">
                    <span class="text-gray-900 font-bold">Final Amount:</span>
                    <span id="final-amount" class="text-lg font-bold text-blue-600">₹0</span>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <x-heroicon-s-document-text class="w-4 h-4 inline mr-2" />
                    Notes (Optional)
                </label>
                <textarea
                    name="notes"
                    placeholder="Add any additional notes..."
                    rows="2"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button
                    type="button"
                    onclick="closeDiscountForm()"
                    class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-smooth"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-smooth flex items-center justify-center gap-2"
                >
                    <x-heroicon-s-check class="w-5 h-5" />
                    <span id="submit-text">Confirm & Record Visit</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let vendorDiscountPercent = {{ auth()->user()->vendor->discount_percentage ?? 0 }};

    function calculateDiscount() {
        const originalAmount = parseFloat(document.getElementById('original-amount').value) || 0;
        
        if (originalAmount > 0) {
            const discountAmount = (originalAmount * vendorDiscountPercent) / 100;
            const finalAmount = originalAmount - discountAmount;

            document.getElementById('discount-percent').textContent = vendorDiscountPercent + '%';
            document.getElementById('discount-amount').textContent = '₹' + discountAmount.toFixed(2);
            document.getElementById('final-amount').textContent = '₹' + finalAmount.toFixed(2);
            document.getElementById('discount-display').classList.remove('hidden');
        } else {
            document.getElementById('discount-display').classList.add('hidden');
        }
    }

    function closeDiscountForm() {
        document.getElementById('discount-modal').classList.add('hidden');
        document.getElementById('discount-form').reset();
        document.getElementById('discount-display').classList.add('hidden');
    }

    async function submitDiscount(event) {
        event.preventDefault();

        const submitBtn = event.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="w-5 h-5 animate-spin inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';

        try {
            const formData = new FormData(document.getElementById('discount-form'));
            const data = Object.fromEntries(formData);

            const response = await fetch('{{ route('vendor.scan.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                // Close the modal first
                closeDiscountForm();
                
                // Show thank you popup
                Swal.fire({
                    icon: 'success',
                    title: 'Thank You!',
                    html: `<div class="text-center"><p class="text-lg mb-2">Patient: <strong>${result.visit.patient_name}</strong></p><p class="text-green-600 font-bold">Discount: ₹${result.visit.discount_amount}</p></div>`,
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Next Patient',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didClose: () => { resetScan(); }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Failed to record visit',
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while processing',
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<x-heroicon-s-check class="w-5 h-5" /> <span>Confirm & Record Visit</span>';
        }
    }

    function generateDiscountPDF(visit) {
        // You can use a library like jsPDF or Puppeteer for PDF generation
        // For now, we'll create a simple printable format
        const printWindow = window.open('', '_blank');
        const html = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Discount Receipt - ${visit.patient_name}</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
                    .header h1 { margin: 0; color: #1976d2; }
                    .content { margin: 20px 0; }
                    .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #ddd; }
                    .row.total { font-weight: bold; border-bottom: 2px solid #333; margin-top: 10px; }
                    .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>Assam Health Card</h1>
                    <h2>Discount Receipt</h2>
                </div>
                <div class="content">
                    <div class="row">
                        <span>Date:</span>
                        <span>${new Date().toLocaleDateString()}</span>
                    </div>
                    <div class="row">
                        <span>Patient:</span>
                        <span>${visit.patient_name}</span>
                    </div>
                    <div class="row">
                        <span>Vendor:</span>
                        <span>${visit.vendor_name}</span>
                    </div>
                    <div class="row">
                        <span>Original Amount:</span>
                        <span>₹${parseFloat(visit.original_amount).toFixed(2)}</span>
                    </div>
                    <div class="row">
                        <span>Discount (${visit.discount_percentage}%):</span>
                        <span>₹${parseFloat(visit.discount_amount).toFixed(2)}</span>
                    </div>
                    <div class="row total">
                        <span>Final Amount:</span>
                        <span>₹${(parseFloat(visit.original_amount) - parseFloat(visit.discount_amount)).toFixed(2)}</span>
                    </div>
                </div>
                <div class="footer">
                    <p>This is an auto-generated receipt. Please retain for your records.</p>
                    <p>Assam Health Card Portal</p>
                </div>
            </body>
            </html>
        `;
        printWindow.document.write(html);
        printWindow.document.close();
        printWindow.print();

        // Close modal and reset
        setTimeout(() => {
            closeDiscountForm();
            location.reload();
        }, 500);
    }
</script>
