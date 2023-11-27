<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InterviewSelection extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $signedUrl;
    public $candidate;
    public $job_applicant;
    public function __construct($signedUrl, $candidate, $job_applicant = null)
    {
        $this->signedUrl = $signedUrl;
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
                subject: $job->vacant_position . ' Select Date of Interview for Stage ' . $this->job_applicant->stage_id,
            );
        } else {
            return new Envelope(
                subject: 'Select Date for Screening Interview',
            );
        }
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.interview_select',
            with: [
                'signedUrl' => $this->signedUrl,
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
