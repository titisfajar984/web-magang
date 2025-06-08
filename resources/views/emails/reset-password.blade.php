<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h2 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .content {
            font-size: 16px;
            color: #333333;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 12px 25px;
            margin: 20px 0;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #999999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Reset Password</h2>
            <p>Sistem Magang</p>
        </div>

        <div class="content">
            <p>Halo {{ $user->name ?? 'Pengguna' }},</p>
            <p>Kami menerima permintaan untuk mereset password akun Anda. Silakan klik tombol di bawah ini untuk mengatur ulang password Anda:</p>

            <a href="{{ $resetUrl }}" class="button">Atur Ulang Password</a>

            <p>Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Sistem Magang. All rights reserved.
        </div>
    </div>
</body>
</html>
