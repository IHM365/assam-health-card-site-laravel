<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    public function send(object $notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toSms')) {
            return;
        }

        $message = $notification->toSms($notifiable);
        $phone = $notifiable->routeNotificationForSms();

        try {
            // Using Twilio for SMS
            if (env('TWILIO_SID') && env('TWILIO_AUTH_TOKEN')) {
                $this->sendViaTwilio($phone, $message);
            } else {
                // Fallback: Log message
                Log::channel('notifications')->info('SMS (Twilio not configured)', [
                    'to' => $phone,
                    'message' => $message,
                    'timestamp' => now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('notifications')->error('SMS Send Failed', [
                'to' => $phone,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function sendViaTwilio(string $phone, string $message): void
    {
        $response = Http::withBasicAuth(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'))
            ->asForm()
            ->post('https://api.twilio.com/2010-04-01/Accounts/' . env('TWILIO_SID') . '/Messages.json', [
                'From' => env('TWILIO_PHONE_NUMBER'),
                'To' => '+91' . $phone,
                'Body' => $message,
            ]);

        if ($response->successful()) {
            Log::channel('notifications')->info('SMS Sent Successfully', [
                'to' => $phone,
                'message' => $message,
                'timestamp' => now(),
            ]);
        } else {
            throw new \Exception('Twilio SMS failed: ' . $response->body());
        }
    }
}
