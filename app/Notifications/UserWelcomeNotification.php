<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserWelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $username,
        protected string $password,
        protected string $userType,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'sms', 'whatsapp'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Welcome to Assam Health Card, {$notifiable->name}!")
            ->line("Your account has been successfully created. Here are your login credentials:")
            ->line("**Username:** {$this->username}")
            ->line("**Password:** {$this->password}")
            ->line("You can login using your email, phone number, or card ID.")
            ->action('Login Now', url('/login'))
            ->line("Thank you for joining us!")
            ->salutation('Best regards, Assam Health Card Team');
    }

    public function toSms(object $notifiable): string
    {
        return "Welcome to Assam Health Card! Your {$this->userType} account has been created. Username: {$this->username}, Password: {$this->password}. You can login with email, phone, or card ID. Thank you!";
    }

    public function toWhatsApp(object $notifiable): string
    {
        return "🎉 Welcome to Assam Health Card!\n\n" .
               "Your {$this->userType} account is ready. Here are your credentials:\n" .
               "👤 Username: {$this->username}\n" .
               "🔑 Password: {$this->password}\n\n" .
               "Login using: Email, Phone, or Card ID\n\n" .
               "Thank you for joining us! 🙏";
    }
}
