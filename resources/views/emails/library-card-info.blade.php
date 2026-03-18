<!DOCTYPE html>
<html>
<head>
    <title>Library Card</title>
</head>
<body>
    <p>Dear {{ $card->student->first_name }},</p>
    <p>Attached is your Library Card in PDF format.</p>
    <p>Regards,<br>Library Team</p>
</body>
</html>
