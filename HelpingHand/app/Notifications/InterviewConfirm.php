<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class InterviewConfirm extends Notification
{
    use Queueable;

    public $interview;
    /**
     * Create a new notification instance.
     */
    public function __construct($interview)
    {
        $this->interview = $interview;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
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
            //
        ];
    }
    public function toDatabase(object $notifiable): array
    {
        $job_applicant = $this->interview->job_applicant;
        $job = $this->interview->job;

        $candidate = $this->interview->candidate;
        if ($job_applicant) {
            $title = 'Interview Fixed For ' . $candidate->first_name . ' for ' . $job->vacant_position;
            $id = base64_encode($job_applicant->id);
            $url = URL::route('applicant-stage_view', $id);
            $body = $candidate->first_name . " " . $candidate->last_name . 'has cinfirmed date for interview for ' . $job->vacant_position . ' stage ' . $job_applicant->stage_id;
        } else {
            $title = 'Screening Interview Fixed For ' . $candidate->first_name;
            $id = base64_encode($candidate->id);
            $url = URL::route('candidates-view', $id);
            $body = $candidate->first_name . " " . $candidate->last_name . 'has cinfirmed date for Screening';
        }
       
        return [
            'title' => $title,
            'body' => $body,
            'url' => $url,
        ];
    }
}
