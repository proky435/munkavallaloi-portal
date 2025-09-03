<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTicketCreated extends Notification
{
    use Queueable;

    public function __construct(public Ticket $ticket)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.tickets.show', $this->ticket);

        return (new MailMessage)
                    ->subject('Új bejelentés érkezett: #' . $this->ticket->id)
                    ->greeting('Helló!')
                    ->line('Egy új bejelentés érkezett a portálon keresztül.')
                    ->line('Beküldő: ' . $this->ticket->user->name)
                    ->line('Téma: ' . $this->ticket->subject)
                    ->action('Bejelentés megtekintése', $url)
                    ->line('Köszönjük, hogy a portált használja!');
    }
}
