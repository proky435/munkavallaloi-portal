<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentAdded extends Notification
{
    use Queueable;

    public function __construct(public Comment $comment)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Attól függően, hogy ki kapja az e-mailt, más linket generálunk
        $url = $notifiable->is_admin
            ? route('admin.tickets.show', $this->comment->ticket)
            : route('tickets.show', $this->comment->ticket);

        return (new MailMessage)
                    ->subject('Új válasz érkezett a #' . $this->comment->ticket->id . ' számú bejelentéshez')
                    ->greeting('Helló ' . $notifiable->name . '!')
                    ->line('Új válasz érkezett egy bejelentéshez, amit Ön küldött be vagy kezel.')
                    ->line('Válaszadó: ' . $this->comment->user->name)
                    ->action('Bejelentés megtekintése', $url);
    }
}