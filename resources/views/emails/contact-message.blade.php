<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; background:#f4f4f4; padding:24px;">
    <div style="max-width:520px;margin:0 auto;background:#fff;border-radius:8px;padding:32px;">
        <h2 style="color:#111;margin-top:0;">Pesan Baru dari Portfolio</h2>
        <p style="color:#555;">Ada pesan masuk lewat form kontak website kamu.</p>
        <hr style="border:none;border-top:1px solid #eee;margin:20px 0;">
        <p><strong>Nama:</strong> {{ $contactMessage->name }}</p>
        <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
        <p><strong>Pesan:</strong></p>
        <p style="white-space:pre-line;color:#333;">{{ $contactMessage->message }}</p>
        <hr style="border:none;border-top:1px solid #eee;margin:20px 0;">
        <p style="font-size:12px;color:#999;">Dikirim otomatis dari form kontak portfolio.</p>
    </div>
</body>
</html>
