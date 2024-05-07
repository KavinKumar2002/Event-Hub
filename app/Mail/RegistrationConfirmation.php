<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $eventname;
    public $teamname;
   /**
     * Create a new message instance.
     *
     * @param string $name The name of the recipient
     * @param string $teamname The name of the team
     * @param string $eventname The name of the event
     * @return void
     */
    public function __construct($name, $teamname, $eventname)
    {
        $this->name = $name;
        $this->teamname = $teamname;
        $this->eventname = $eventname;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Event Confirmation',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.grp',
            with: [
                'name' => $this->name,
                'teamname' => $this->teamname,
                'eventname' => $this->eventname,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
