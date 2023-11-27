<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewCancel extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $interview;
    public $candidate;
    public $job_applicant;
    public function __construct($interview,$candidate,$job_applicant=null)
    {
        $this->interview = $interview;
        $this->candidate = $candidate;
        $this->job_applicant = $job_applicant;
        // dump($signedUrl);
        // dd($signedUrl,$candidate);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
       
        if ($this->job_applicant) {
            $job = $this->job_applicant->job;
            return new Envelope(
                subject:'Interview Canceled for Stage '.$this->job_applicant->stage_id.' for post '. $job->vacant_position,
            );
        }else{
        return new Envelope(
            subject: 'Screening Interview Cancelled',
        );
    }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.interview_cancel',
            with: [
                'signedUrl' => $this->interview,
                'candidate' => $this->candidate,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
