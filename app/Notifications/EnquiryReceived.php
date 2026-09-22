<?php

namespace App\Notifications;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquiryReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Enquiry $enquiry) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $e = $this->enquiry;

        $mail = (new MailMessage)
            ->subject("New website enquiry: {$e->subject}")
            ->line("Name: {$e->name}")
            ->line("Company: ".($e->company ?: '—'))
            ->line("Email: {$e->email}")
            ->line("Phone: ".($e->phone ?: '—'))
            ->line("Country: ".($e->country ?: '—'))
            ->line('Message:')
            ->line($e->message)
            ->action('Open enquiry inbox', url('/admin'))
            ->replyTo($e->email, $e->name);

        if ($e->product) {
            $mail->line("Product interest: {$e->product->name}");
        }

        return $mail;
    }
}
