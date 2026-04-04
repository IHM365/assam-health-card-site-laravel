<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #3b82f6;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 12px;
        }
        
        .receipt-number {
            background-color: #f3f4f6;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
            color: #1f2937;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 10px;
            font-weight: bold;
            border-left: 4px solid #0369a1;
            margin-bottom: 10px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: bold;
            color: #666;
            width: 40%;
        }
        
        .info-value {
            text-align: right;
            color: #333;
            width: 60%;
        }
        
        .calculation-table {
            width: 100%;
            margin: 15px 0;
        }
        
        .calc-row {
            display: flex;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 4px;
            border-left: 3px solid #d1d5db;
        }
        
        .calc-label {
            flex: 1;
            font-weight: bold;
        }
        
        .calc-value {
            font-weight: bold;
            text-align: right;
            min-width: 100px;
        }
        
        .calc-row.original .calc-label {
            color: #374151;
        }
        
        .calc-row.discount .calc-label {
            color: #10b981;
        }
        
        .calc-row.discount .calc-value {
            color: #10b981;
        }
        
        .calc-row.final {
            background-color: #ecfdf5;
            border-left-color: #10b981;
            margin-bottom: 0;
        }
        
        .calc-row.final .calc-label {
            color: #047857;
            font-size: 16px;
        }
        
        .calc-row.final .calc-value {
            color: #047857;
            font-size: 18px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .thank-you {
            color: #0369a1;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .vendor-details {
            font-size: 11px;
            margin-top: 10px;
        }
        
        .currency {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>DISCOUNT RECEIPT</h1>
            <p>Assam Health Card System</p>
        </div>

        <!-- Receipt Number -->
        <div class="receipt-number">
            Receipt #{{ sprintf('%05d', $visit->id) }} | {{ $visit->visited_at->format('d M Y, h:i A') }}
        </div>

        <!-- Patient Information -->
        <div class="section">
            <div class="section-title">Patient Information</div>
            <div class="info-row">
                <span class="info-label">Patient Name:</span>
                <span class="info-value">{{ $patient->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Patient ID:</span>
                <span class="info-value">#{{ $patient->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $patient->user->phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Card Type:</span>
                <span class="info-value">{{ ucfirst($patient->card_type) }} Card</span>
            </div>
        </div>

        <!-- Vendor Information -->
        <div class="section">
            <div class="section-title">Vendor Information</div>
            <div class="info-row">
                <span class="info-label">Vendor Name:</span>
                <span class="info-value">{{ $vendor->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Discount Rate:</span>
                <span class="info-value">{{ $visit->discount_percentage }}%</span>
            </div>
        </div>

        <!-- Discount Calculation -->
        <div class="section">
            <div class="section-title">Discount Calculation</div>
            
            <div class="calc-row original">
                <span class="calc-label">Original Amount (Service Cost):</span>
                <span class="calc-value"><span class="currency">₹</span>{{ number_format($visit->original_amount, 2) }}</span>
            </div>

            <div class="calc-row discount">
                <span class="calc-label">Discount ({{ $visit->discount_percentage }}%):</span>
                <span class="calc-value">- <span class="currency">₹</span>{{ number_format($visit->discount_amount, 2) }}</span>
            </div>

            <div class="calc-row final">
                <span class="calc-label">Final Amount (Patient Pays):</span>
                <span class="calc-value"><span class="currency">₹</span>{{ number_format($visit->original_amount - $visit->discount_amount, 2) }}</span>
            </div>
        </div>

        <!-- Amount Saved Message -->
        <div class="section" style="text-align: center; background-color: #fef3c7; padding: 15px; border-radius: 4px; border: 2px solid #fcd34d;">
            <p style="font-weight: bold; color: #92400e; margin-bottom: 5px;">Amount Saved!</p>
            <p style="font-size: 18px; color: #ca8a04;"><span class="currency">₹</span>{{ number_format($visit->discount_amount, 2) }} saved on this transaction</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">Thank you for using Assam Health Card!</div>
            <div class="vendor-details">
                Vendor: {{ $vendor->user->name }}<br>
                Generated: {{ now()->format('d M Y, h:i A') }}
            </div>
            <p style="margin-top: 15px; font-size: 10px; color: #999;">
                This receipt is a digital acknowledgment of the discount applied to the patient's bill.
            </p>
        </div>
    </div>
</body>
</html>
