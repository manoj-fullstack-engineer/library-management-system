<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LibraryCardPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $card;
    public $pdfData;

    /**
     * Create a new message instance.
     */
    public function __construct($card, $pdfData)
    {
        $this->card = $card;
        $this->pdfData = $pdfData;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🎓 Your Library Card')
            ->view('emails.library-card-info')
            ->with([
                'name' => $this->card->student->first_name . ' ' . $this->card->student->last_name,
                'cardNumber' => $this->card->card_number,
            ])
            ->attachData($this->pdfData, 'LibraryCard.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
