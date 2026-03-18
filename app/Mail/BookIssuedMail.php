<?php

namespace App\Mail;

use App\Models\BookIssue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookIssuedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $issue;

    public function __construct(BookIssue $issue)
    {
        $this->issue = $issue;
    }

    public function build()
    {
        return $this->subject('Balganga e-Library Book Issued')
            ->markdown('emails.book_issued');
    }
}
