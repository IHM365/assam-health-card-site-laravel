<?php

namespace App\Services;

use App\Models\User;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class AcknowledgementLetterService
{
    /**
     * Generate acknowledgement letter PDF
     */
    public function generateLetter(User $user): string
    {
        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 20,
                'margin_bottom' => 15,
                'margin_header' => 10,
                'margin_footer' => 10,
            ]);

            $html = $this->generateLetterHTML($user);
            
            $mpdf->WriteHTML($html);

            $letterPath = 'letters/acknowledgement_' . $user->id . '_' . now()->timestamp . '.pdf';
            $letterFullPath = public_path($letterPath);
            
            if (!is_dir(public_path('letters'))) {
                mkdir(public_path('letters'), 0755, true);
            }

            $mpdf->Output($letterFullPath, 'F');

            return $letterPath;
        } catch (MpdfException $e) {
            \Log::error('Acknowledgement letter PDF generation failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Generate letter HTML content
     */
    private function generateLetterHTML(User $user): string
    {
        $generatedDate = now()->format('d/m/Y');
        $validityDate = now()->addYears(5)->format('d/m/Y');
        $cardID = 'AHC-' . str_pad($user->id, 6, '0', STR_PAD_LEFT);

        $html = <<<EOT
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    line-height: 1.6;
                    color: #333;
                }
                .letterhead {
                    text-align: center;
                    margin-bottom: 30px;
                    border-bottom: 3px solid #1976d2;
                    padding-bottom: 15px;
                }
                .logo {
                    font-size: 28px;
                    font-weight: bold;
                    color: #1976d2;
                    margin-bottom: 5px;
                }
                .logo::before {
                    content: "✚ ";
                    color: #00a86b;
                }
                .subtitle {
                    font-size: 12px;
                    color: #666;
                    margin-bottom: 3px;
                }
                .contact-info {
                    font-size: 10px;
                    color: #999;
                }
                .letter-content {
                    margin-top: 20px;
                }
                .date-section {
                    text-align: right;
                    margin-bottom: 20px;
                    font-size: 12px;
                }
                .greeting {
                    margin-bottom: 15px;
                    font-size: 14px;
                    font-weight: bold;
                }
                .section-title {
                    font-size: 13px;
                    font-weight: bold;
                    color: #1976d2;
                    margin-top: 15px;
                    margin-bottom: 8px;
                    border-bottom: 2px solid #e0e0e0;
                    padding-bottom: 5px;
                }
                .section-content {
                    font-size: 12px;
                    margin-bottom: 10px;
                    line-height: 1.8;
                }
                .info-box {
                    background: #f5f7fa;
                    border-left: 4px solid #1976d2;
                    padding: 12px 15px;
                    margin: 15px 0;
                    font-size: 11px;
                }
                .info-box-title {
                    font-weight: bold;
                    color: #1976d2;
                    margin-bottom: 5px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 10px 0;
                    font-size: 11px;
                }
                table td {
                    padding: 8px;
                    border-bottom: 1px solid #e0e0e0;
                }
                table td.label {
                    font-weight: bold;
                    width: 40%;
                    color: #1976d2;
                }
                .signature-section {
                    margin-top: 40px;
                    display: flex;
                    justify-content: space-between;
                }
                .signature-block {
                    width: 40%;
                    text-align: center;
                }
                .signature-line {
                    border-top: 2px solid #333;
                    margin: 20px 0 5px 0;
                }
                .signature-title {
                    font-size: 11px;
                    font-weight: bold;
                }
                .footer-note {
                    margin-top: 30px;
                    padding-top: 15px;
                    border-top: 1px solid #ccc;
                    font-size: 10px;
                    color: #666;
                    text-align: center;
                }
                ul {
                    margin-left: 20px;
                }
                li {
                    margin-bottom: 5px;
                    font-size: 11px;
                }
            </style>
        </head>
        <body>
            <div class="letterhead">
                <div class="logo">ASSAM HEALTH CARD</div>
                <div class="subtitle">Digital Health Identity & Network Access</div>
                <div class="contact-info">Government of Assam | Department of Health</div>
            </div>

            <div class="letter-content">
                <div class="date-section">
                    Date: {$generatedDate}
                </div>

                <div class="greeting">
                    Dear {$user->name},
                </div>

                <div class="section-content">
                    We are pleased to confirm that your Assam Health Card has been successfully registered and activated. This letter serves as an official acknowledgement and proof of your enrollment in the Assam Health Card network.
                </div>

                <div class="info-box">
                    <div class="info-box-title">✓ REGISTRATION CONFIRMED</div>
                    <table>
                        <tr>
                            <td class="label">Card ID:</td>
                            <td><strong>{$cardID}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Registered Name:</td>
                            <td>{$user->name}</td>
                        </tr>
                        <tr>
                            <td class="label">Email:</td>
                            <td>{$user->email}</td>
                        </tr>
                        <tr>
                            <td class="label">Phone:</td>
                            <td>{$user->phone}</td>
                        </tr>
                        <tr>
                            <td class="label">Registration Date:</td>
                            <td>{$generatedDate}</td>
                        </tr>
                        <tr>
                            <td class="label">Card Validity:</td>
                            <td>Until {$validityDate}</td>
                        </tr>
                    </table>
                </div>

                <div class="section-title">📋 BENEFITS & FEATURES</div>
                <div class="section-content">
                    With your Assam Health Card, you now have access to:
                    <ul>
                        <li><strong>Networked Healthcare Facilities:</strong> Access to a wide network of partner hospitals, clinics, and diagnostic centers across Assam</li>
                        <li><strong>Simplified Appointments:</strong> Easy booking and management of medical appointments online</li>
                        <li><strong>Health Records:</strong> Secure digital storage of your medical history and prescriptions</li>
                        <li><strong>Priority Services:</strong> Dedicated customer support and priority access to healthcare services</li>
                        <li><strong>Family Members:</strong> Extend your card benefits to up to 4 family members</li>
                        <li><strong>Insurance Coverage:</strong> Integrated health insurance for covered services</li>
                    </ul>
                </div>

                <div class="section-title">📖 HOW TO USE YOUR CARD</div>
                <div class="section-content">
                    <strong>1. Download Your Digital Card:</strong> Visit our portal or mobile app to download your digital card and print this acknowledgement letter.<br><br>
                    <strong>2. QR Code Access:</strong> Your unique QR code allows healthcare providers to instantly verify your registration and access your health profile securely.<br><br>
                    <strong>3. Book Appointments:</strong> Use the online portal to book appointments at any partner facility in the network.<br><br>
                    <strong>4. Access Health Records:</strong> Maintain and view your health records anytime through the secure online platform.
                </div>

                <div class="section-title">⚠️ IMPORTANT INFORMATION</div>
                <div class="section-content">
                    <ul>
                        <li>Keep your Card ID safe and confidential</li>
                        <li>Your card is valid until {$validityDate} and can be renewed 30 days before expiry</li>
                        <li>For any changes in personal information, please contact our support team</li>
                        <li>In case of lost card, report immediately for card replacement</li>
                        <li>Your health data is encrypted and stored securely per government standards</li>
                    </ul>
                </div>

                <div class="section-title">📞 SUPPORT & CONTACT</div>
                <div class="section-content">
                    If you have any questions or need assistance:
                    <ul>
                        <li><strong>Email:</strong> support@assamhealthcard.gov.in</li>
                        <li><strong>Phone:</strong> 1800-123-4567 (Toll Free)</li>
                        <li><strong>Website:</strong> www.assamhealthcard.gov.in</li>
                        <li><strong>WhatsApp Support:</strong> +91-9876543210</li>
                    </ul>
                </div>

                <div class="info-box">
                    <div class="info-box-title">🎯 NEXT STEPS</div>
                    <div style="font-size: 11px; line-height: 1.8;">
                        <strong>1.</strong> Download your digital health card from the portal<br>
                        <strong>2.</strong> Print this acknowledgement letter and keep it safe<br>
                        <strong>3.</strong> Share your Card ID with family members for their registration<br>
                        <strong>4.</strong> Set up your health profile and medical history<br>
                        <strong>5.</strong> Book your first appointment at a partner facility
                    </div>
                </div>

                <div class="section-title">✅ ACKNOWLEDGEMENT</div>
                <div class="section-content">
                    This letter confirms that you have successfully completed the registration process for the Assam Health Card. Your enrollment is now active, and you can begin using all benefits immediately.
                </div>

                <div class="signature-section">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-title">Authorized Signatory</div>
                        <div style="font-size: 10px; margin-top: 5px;">Assam Health Card Authority</div>
                    </div>
                </div>

                <div class="footer-note">
                    <strong>Document Reference:</strong> AHC-ACK-{$user->id}-{$generatedDate}<br>
                    This is an electronically generated document. No additional signature required.<br>
                    Please keep this acknowledgement for your records. Valid as proof of enrollment.
                </div>
            </div>
        </body>
        </html>
        EOT;

        return $html;
    }
}
