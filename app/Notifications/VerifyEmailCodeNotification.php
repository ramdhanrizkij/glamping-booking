<?php

namespace App\Notifications;

use App\Support\EmailVerificationCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $code,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Verifikasi Email Anda')
            ->greeting('Halo '.$notifiable->name.',')
            ->line('Gunakan kode berikut untuk memverifikasi email akun Anda:')
            ->line($this->code)
            ->line('Kode ini berlaku selama '.EmailVerificationCodeService::TTL_MINUTES.' menit.')
            ->line('Jika Anda tidak merasa membuat akun ini, abaikan email ini.');
    }
}
