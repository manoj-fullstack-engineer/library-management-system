@component('mail::message')
# New Contact Message

Name: {{ $enquiry->name }}  
Email: {{ $enquiry->email }}  
Phone: {{ $enquiry->phone }}  
Subject: {{ $enquiry->subject }}

Message:  
{{ $enquiry->message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
