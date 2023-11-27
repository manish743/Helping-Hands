<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class CandidateRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    public $candidate;
    /**
     * Create a new notification instance.
     */
    public function __construct($candidate)
    {
        $this->candidate=$candidate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
        // return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
               
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'body' => 'Yaay! You made it to here! You logged in to view the notification, SO damn Nice!',
        ];
    }
    public function toDatabase(object $notifiable): array
    {
        $id = base64_encode($this->candidate->id);
        $url = URL::route('candidates-view',$id);
        return [
            'title' => 'New Candidate Registered!',
            'body' => $this->candidate->first_name.$this->candidate->last_name.'has joined CIM',
            'url' => $url,
        ];
    }
}
