<?php

namespace App\Services;

use App\Models\Patient;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QRCodeException;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class CardGenerationService
{
    /**
     * Generate QR code for patient card
     */
    public function generateQRCode(Patient $patient, string $type = 'verify'): string
    {
        try {
            $qrDir = public_path('qrcodes');
            if (!is_dir($qrDir)) {
                mkdir($qrDir, 0755, true);
            }

            $filename = ($type === 'verify') ? 'patient_' . $patient->id . '.png' : 'patient_' . $patient->id . '_appointments.png';
            $qrCodePath = $qrDir . '/' . $filename;

            $qrData = ($type === 'verify') 
                ? url(route('public.verify.show', $patient, false))
                : url(route('public.home', false));

            $qrCode = new QRCode(['version' => 5, 'eccLevel' => 'M']);
            $qrCode->render($qrData, $qrCodePath);

            return base64_encode(file_get_contents($qrCodePath));
        } catch (QRCodeException $e) {
            \Log::error('QR Code generation failed', ['error' => $e->getMessage()]);
            return '';
        }
    }

    /**
     * Generate health card PDF (Front & Back)
     */
    public function generateCard(Patient $patient): string
    {
        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [85.6, 53.98],
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
            ]);

            $qrCodeVerify = $this->generateQRCode($patient, 'verify');
            $qrCodeAppointments = $this->generateQRCode($patient, 'appointments');
            $profileImage = $patient->profile_image ? public_path($patient->profile_image) : null;

            // Front
            $frontHtml = $this->generateCardFront($patient, $qrCodeVerify, $profileImage);
            $mpdf->WriteHTML($frontHtml);
            $mpdf->AddPage();

            // Back
            $backHtml = $this->generateCardBack($qrCodeAppointments);
            $mpdf->WriteHTML($backHtml);

            $cardPath = 'cards/patient_' . $patient->id . '_' . now()->timestamp . '.pdf';
            if (!is_dir(public_path('cards'))) {
                mkdir(public_path('cards'), 0755, true);
            }

            $mpdf->Output(public_path($cardPath), 'F');
            return $cardPath;
        } catch (MpdfException $e) {
            \Log::error('Card PDF generation failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function generateCardFront(Patient $patient, string $qrBase64, ?string $profilePath): string
    {
        $validity = $patient->card_validity_date ? $patient->card_validity_date->format('m/y') : now()->addYears(1)->format('m/y');
        $cardId = 'AHC-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
        $cardType = $patient->card_type === 'family' ? 'Family Card' : 'Individual';

        $profile = ($profilePath && file_exists($profilePath))
            ? '<img src="' . $profilePath . '" />'
            : '<div style="width:100%;height:100%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;font-size:11pt;">' . substr($patient->user->name, 0, 1) . '</div>';

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; }
        .card {
            width: 85.6mm;
            height: 53.98mm;
            background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e9 100%);
            padding: 0;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(90deg, #1976d2 0%, #00897b 100%);
            color: white;
            padding: 2mm 3mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 10.5mm;
        }
        .header-left { display: flex; align-items: center; gap: 1.5mm; font-size: 6.5pt; font-weight: bold; }
        .logo { width: 7mm; height: 7mm; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1976d2; font-weight: bold; }
        .header-right { font-size: 6pt; font-weight: bold; }
        .body { display: flex; gap: 2mm; padding: 2.5mm; height: 43.48mm; }
        .profile { width: 12mm; height: 12mm; flex-shrink: 0; border-radius: 50%; overflow: hidden; }
        .info { flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .name { font-size: 9pt; font-weight: bold; color: #1a1a1a; line-height: 1; }
        .label { font-size: 5pt; color: #666; margin-top: 1mm; font-weight: 600; }
        .value { font-size: 6.5pt; font-weight: bold; color: #1976d2; }
        .qr { width: 15mm; display: flex; flex-direction: column; align-items: center; justify-content: space-between; }
        .qr-box { width: 13mm; height: 13mm; background: white; border: 0.5pt solid #ddd; display: flex; align-items: center; justify-content: center; }
        .qr-box img { width: 100%; height: 100%; }
        .qr-text { font-size: 4pt; font-weight: bold; color: #333; text-align: center; line-height: 1; margin-top: 0.3mm; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="header-left">
                <div class="logo">✚</div>
                <div>Assam Health Card</div>
            </div>
            <div class="header-right">$cardType</div>
        </div>
        <div class="body">
            <div class="profile">$profile</div>
            <div class="info">
                <div class="name">{$patient->user->name}</div>
                <div>
                    <div class="label">Card ID</div>
                    <div class="value">$cardId</div>
                </div>
                <div>
                    <div class="label">Valid Up To</div>
                    <div class="value">$validity</div>
                </div>
            </div>
            <div class="qr">
                <div class="qr-box"><img src="data:image/png;base64,$qrBase64" /></div>
                <div class="qr-text">SCAN<br>VERIFY</div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function generateCardBack(string $qrBase64): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:Arial,sans-serif; }
        .card {
            width: 85.6mm;
            height: 53.98mm;
            background: linear-gradient(135deg, #e3f2fd 0%, #e8f5e9 100%);
            padding: 0;
            overflow: hidden;
            position: relative;
        }
        .header {
            background: linear-gradient(90deg, #1976d2 0%, #00897b 100%);
            color: white;
            padding: 2mm 3mm;
            display: flex;
            align-items: center;
            gap: 1.5mm;
            height: 9mm;
        }
        .logo { width: 6mm; height: 6mm; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1976d2; font-weight: bold; font-size: 4.5pt; }
        .header-title { font-size: 7.5pt; font-weight: bold; }
        .body {
            display: flex;
            height: 44.98mm;
            padding: 2mm 1.5mm;
            gap: 1.5mm;
            position: relative;
        }
        .left {
            flex: 0 0 32%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .watermark { font-size: 5.5pt; font-weight: bold; color: rgba(25,118,210,0.12); line-height: 1; text-transform: uppercase; writing-mode: vertical-rl; transform: rotate(180deg); }
        .center {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }
        .box {
            border: 0.5pt dashed #1976d2;
            padding: 1.2mm;
            text-align: center;
            background: rgba(25,118,210,0.04);
            border-radius: 1.5mm;
        }
        .box-title { font-size: 6pt; font-weight: bold; color: #333; line-height: 1.1; }
        .box-sub { font-size: 3.5pt; color: #888; margin-top: 0.3mm; }
        .right {
            flex: 0 0 28%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }
        .qr-sm { width: 10mm; height: 10mm; background: white; border: 0.5pt solid #ddd; display: flex; align-items: center; justify-content: center; }
        .qr-sm img { width: 100%; height: 100%; }
        .qr-label { font-size: 3.5pt; color: #666; font-weight: bold; margin-top: 0.2mm; }
        .footer {
            background: linear-gradient(90deg, #1976d2 0%, #00897b 100%);
            color: white;
            padding: 0.8mm 1.5mm;
            font-size: 4.5pt;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 5mm;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.2;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <div class="logo">✚</div>
            <div class="header-title">Our Healthcare Network</div>
        </div>
        <div class="body">
            <div class="left">
                <div class="watermark">ONE CARD COMPLETE<br>HEALTHCARE</div>
            </div>
            <div class="center">
                <div class="box">
                    <div class="box-title">LABS | CLINIC<br>HOSPITALS | PHARMACY</div>
                    <div class="box-sub">SCAN TO VIEW PARTNER LIST</div>
                </div>
                <div class="box">
                    <div class="box-title">APPOINTMENTS</div>
                    <div class="box-sub">SCAN TO BOOK NOW</div>
                </div>
            </div>
            <div class="right">
                <div class="qr-sm"><img src="data:image/png;base64,$qrBase64" /></div>
                <div class="qr-label">BOOK<br>NOW</div>
            </div>
        </div>
        <div class="footer">
            +91-7086913787 | support@assamhealthcard.com
        </div>
    </div>
</body>
</html>
HTML;
    }
}
