@component('mail::message')
# Book Issued Successfully 📚

Dear {{ $issue->student->first_name }},

The following book has been issued to your account:

- **Title:** {{ $issue->book_title }}
- **Issued On:** {{ \Carbon\Carbon::parse($issue->issued_at)->format('d M Y') }}
- **Due Date:** {{ \Carbon\Carbon::parse($issue->due_date)->format('d M Y') }}

Please ensure the book is returned on time to avoid fines.

Thanks,  
Library Management
@endcomponent
