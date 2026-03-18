<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Contact;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use App\Mail\ContactSubmitted;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|digits:10',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save to database
        $enquiry = Enquiry::create($data);

        // Send email notification
        Mail::to(config('mail.from.address'))->send(new ContactSubmitted($enquiry));

        // Return plain 'OK' string so JS knows it's successful
        return response('OK', 200);
    }
}
