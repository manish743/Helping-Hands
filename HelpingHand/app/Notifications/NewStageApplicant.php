<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class NewStageApplicant extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $user;
    protected $job_applicant;
    public function __construct($user, $job_applicant)
    {
       $this->user = $user;
       $this->job_applicant = $job_applicant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
        // return ['mail'];
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
        $id = base64_encode($this->job_applicant->id);
        $job = $this->job_applicant->job;
        $candidate = $this->job_applicant->candidate;
        $url = URL::route('applicant-stage_view',$id);
        Log::info($url);
        // {{ route('jobs-applicants', base64_encode($item->id)) }}
        // dump($this->job);
        // dd($this->candidate);
        return [
            'title' => 'New Applicant  has been recommended to stage:'.$this->job_applicant->stage_id.' for job:  '.$job->vacant_position,
            'body' => $candidate->first_name.$candidate->last_name.' has been recommended to stage:'.$this->job_applicant->stage_id.' for job: '.$job->vacant_position,
            'url' => $url,
        ];
    }
}
