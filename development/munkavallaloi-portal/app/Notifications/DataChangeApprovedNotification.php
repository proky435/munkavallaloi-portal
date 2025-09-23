<?php

namespace App\Notifications;

use App\Models\DataChangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DataChangeApprovedNotification extends Notification implements ShouldQueue
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
        
        if ($scheduledFor) {
            return (new MailMessage)
                ->subject('Adatváltozás kérés jóváhagyva - Ütemezett alkalmazás')
                ->greeting('Kedves ' . $notifiable->name . '!')
                ->line('Az adatváltozás kérése jóváhagyásra került.')
                ->line('**Kérés azonosító:** #' . $this->dataChangeRequest->id)
                ->line('**Típus:** ' . $this->dataChangeRequest->dataChangeType->name)
                ->line('**Alkalmazás dátuma:** ' . $scheduledFor->format('Y. m. d. H:i'))
                ->line('Az adatok automatikusan alkalmazásra kerülnek a megadott időpontban.')
                ->line('Egy nappal a változás előtt emlékeztető emailt fog kapni.')
                ->action('Kérés megtekintése', route('data-change.show-request', $this->dataChangeRequest))
                ->line('Köszönjük!');
        } else {
            return (new MailMessage)
                ->subject('Adatváltozás kérés jóváhagyva')
                ->greeting('Kedves ' . $notifiable->name . '!')
                ->line('Az adatváltozás kérése jóváhagyásra került és alkalmazásra is került.')
                ->line('**Kérés azonosító:** #' . $this->dataChangeRequest->id)
                ->line('**Típus:** ' . $this->dataChangeRequest->dataChangeType->name)
                ->action('Kérés megtekintése', route('data-change.show-request', $this->dataChangeRequest))
                ->line('Köszönjük!');
        }
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data_change_request_id' => $this->dataChangeRequest->id,
            'type' => 'approved',
            'scheduled_for' => $this->dataChangeRequest->scheduled_for,
        ];
    }
}
