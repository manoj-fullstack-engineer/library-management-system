<?php

namespace App\Mail;

use App\Models\Enquiry; // 👈 Update from Contact to Enquiry
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry; // 👈 Rename to match

    public function __construct(Enquiry $enquiry) // 👈 Typehint with Enquiry
    {
        $this->enquiry = $enquiry;
    }

    public function build()
    {
        return $this->subject('New Contact Message Received')
                    ->markdown('emails.contacts.submitted');
    }
}
