<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CategoryTicketCreated extends Notification
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Új bejelentés érkezett: ' . $this->ticket->category->name)
                    ->greeting('Új bejelentés érkezett!')
                    ->line('Egy új bejelentés érkezett a következő kategóriában: **' . $this->ticket->category->name . '**')
                    ->line('**Beküldő:** ' . $this->ticket->user->name)
                    ->line('**Tárgy:** ' . $this->ticket->subject)
                    ->line('**Üzenet:** ' . $this->ticket->message)
                    ->line('**Dátum:** ' . $this->ticket->created_at->format('Y-m-d H:i'))
                    ->action('Bejelentés megtekintése', route('admin.tickets.show', $this->ticket))
                    ->line('Kérjük, kezelje a bejelentést a lehető leghamarabb.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'category' => $this->ticket->category->name,
            'subject' => $this->ticket->subject,
        ];
    }
}
