<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $resetUrl;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $token)
    {
        //
        $this->user = $user;
        $this->resetUrl = $this->resetUrl($user, $token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Réinitialisation de mot de passe')
            ->markdown('emails.reset_password')
            ->with([
                'resetUrl' => $this->resetUrl,
            ]);
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Reset Password Email',
    //     );
    // }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         markdown: 'emails.reset_password',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: $this->markdown,
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

    protected function resetUrl($user, $token)
    {
        return URL::signedRoute('reset-password', ['email' => $user->email, 'token' => $token]);
    }
}
