<?php

namespace App\Notifications;

use App\Models\DataChangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DataChangeReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private DataChangeRequest $dataChangeRequest
    ) {}

    /**
     * Get the notification's delivery channels.
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
        $scheduledFor = $this->dataChangeRequest->scheduled_for;
        
        return (new MailMessage)
            ->subject('Emlékeztető: Holnap lép életbe az adatváltozás')
            ->greeting('Kedves ' . $notifiable->name . '!')
            ->line('Emlékeztetjük, hogy holnap lép életbe a jóváhagyott adatváltozása.')
            ->line('**Kérés azonosító:** #' . $this->dataChangeRequest->id)
            ->line('**Típus:** ' . $this->dataChangeRequest->dataChangeType->name)
            ->line('**Alkalmazás dátuma:** ' . $scheduledFor->format('Y. m. d. H:i'))
            ->line('Az adatok automatikusan alkalmazásra kerülnek a megadott időpontban.')
            ->line('Ha bármilyen kérdése van, kérjük vegye fel a kapcsolatot a HR osztállyal.')
            ->action('Kérés megtekintése', route('data-change.show-request', $this->dataChangeRequest))
            ->line('Köszönjük!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data_change_request_id' => $this->dataChangeRequest->id,
            'type' => 'reminder',
            'scheduled_for' => $this->dataChangeRequest->scheduled_for,
        ];
    }
}
