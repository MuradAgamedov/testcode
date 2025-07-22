<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SendInitialPassword extends Notification
{ 
    use Queueable;

    public function __construct(public string $plainPassword) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Sistemə giriş şifrəniz')
            ->greeting("Salam, {$notifiable->name}")
            ->line('Sistemə giriş üçün şifrəniz aşağıdakıdır:')
            ->line("🔐 Şifrə: **{$this->plainPassword}**")
            ->line('Zəhmət olmasa, ilk girişdə bu şifrəni dəyişin.');
    }
}
