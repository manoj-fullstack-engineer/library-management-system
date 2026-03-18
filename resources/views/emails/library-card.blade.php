@component('mail::message')
# Library Card Issued

Dear {{ $libraryCard->student->first_name }},

Your library card has been issued successfully. Please find the attached PDF of your card.

Thanks,  
{{ config('app.name') }}
@endcomponent
