<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PanelSchedule extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

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
        $this->job = $this->job_applicant->job;
        return new Envelope(
            subject: $this->job->vacant_position . ' Confirm Panel Interview Date for Stage ' . $this->job_applicant->stage_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.panel_confirm',
            with: [
                'signedUrl' => $this->signedUrl,
                'panel' => $this->panel,
                'job_applicant' => $this->job_applicant,
                'job' => $this->job,
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
