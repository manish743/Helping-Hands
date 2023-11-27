<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCaeStudy extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $job;
    public $job_applicant;
    public $candidate;
    public $signedUrl;
    public $case_study;
    public $pdf;
   
    public function __construct( $job_applicant,$signedUrl,$case_study)
    {
        $this->job = $job_applicant->job;
        $this->job_applicant = $job_applicant;
        $this->candidate = $job_applicant->candidate;
        $this->signedUrl = $signedUrl;
        $this->case_study = $case_study;
        Log::info('Inside the Send Case Study File');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Case Study Material for Parctical evaluation for Job: '.$this->job->vacant_position,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.case_study_material',
            with:[
                'signedUrl' => $this->signedUrl,
                'candidate' => $this->candidate,
                'job_applicant' => $this->job_applicant,
                'job' => $this->job,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf_file = $this->case_study->case_study_material;
        $pdfPath = $pdf_file;
        $attachmentPath = public_path($pdfPath); // Assuming $pdfPath is a public path
        $attachmentName = 'casestudymaterial.pdf'; // The name to be used for the attachment in the email
        Log::info('Inside the Send Case Study attachement');
        return [
            Attachment::fromPath($attachmentPath)
            ->as($attachmentName)
            ->withMime('application/pdf'),
        ];
    }
}
