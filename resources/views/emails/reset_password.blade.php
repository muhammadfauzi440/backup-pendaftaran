<!DOCTYPE html>
<html>
<head>
    <style>
        .btn { background-color: #dc2626; color: white; padding: 15px 25px; text-decoration: none; border-radius: 12px; font-weight: bold; display: inline-block; }
    </style>
</head>
<body style="font-family: sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: white; max-width: 600px; margin: auto; padding: 40px; border-radius: 20px;">
        <h2 style="text-transform: uppercase; letter-spacing: -1px;">Permintaan Atur Ulang Sandi</h2>
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di <strong>Portal Magang PT Global Intermedia Nusantara</strong>. Silakan klik tombol di bawah ini untuk melanjutkan:</p>
        
        <div style="text-align: center; margin: 40px 0;">
            <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}" class="btn" style="color: white;">RESET KATA SANDI</a>
        </div>

        <p style="font-size: 12px; color: #777;">Tautan ini akan kedaluwarsa dalam 60 menit. Jika Anda tidak merasa meminta hal ini, abaikan saja email ini.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="font-size: 10px; color: #aaa; text-align: center;">&copy; {{ date('Y') }} PT Global Intermedia Nusantara</p>
    </div>
</body>
</html>