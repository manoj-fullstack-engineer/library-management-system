<?php

namespace App\Mail;

use App\Models\BookIssue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookReturnedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookIssue;

    public function __construct(BookIssue $bookIssue)
    {
        $this->bookIssue = $bookIssue;
    }

    public function build()
    {
        return $this->subject('📚 Book Returned - Summary')
                    ->view('emails.book_returned');
    }
}
