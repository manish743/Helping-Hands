<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PanelScoreLink extends Mailable
{
    use Queueable, SerializesModels;

    public $panel;
    public $signedUrl;
    public $job_applicant;
    public $job;
    public function __construct($panel, $signedUrl,$job_applicant)
    {
        $this->panel=$panel;
        $this->signedUrl=$signedUrl;
        $this->job_applicant=$job_applicant;
        Log::info('Inside PanelSchedule Mail for:'.$panel->email);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Panel Score Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
