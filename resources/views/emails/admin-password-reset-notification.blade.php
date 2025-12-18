<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Reset Password</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 4px; margin-bottom: 20px; }
        .content { padding: 20px; border: 1px solid #ddd; border-radius: 4px; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666; }
        .button { background-color: #3b82f6; color: white; padding: 12px 20px; border-radius: 4px; text-decoration: none; display: inline-block; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Permintaan Reset Password</h2>
        </div>
        
        <div class="content">
            <p>Halo Admin,</p>
            
            <p>Terdapat permintaan reset password dari pengguna:</p>
            
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; font-weight: bold; width: 30%;">Nama:</td>
                    <td style="padding: 8px;">{{ $userName }}</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 8px; font-weight: bold;">Email:</td>
                    <td style="padding: 8px;">{{ $userEmail }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Tanggal:</td>
                    <td style="padding: 8px;">{{ now()->format('d M Y H:i') }} WIB</td>
                </tr>
            </table>
            
            <p style="margin-top: 20px;">Silahkan masuk ke dashboard admin untuk memproses permintaan ini.</p>
            
            <a href="{{ route('admin.dashboard') }}" class="button">Ke Dashboard Admin</a>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim otomatis oleh Sistem Lapor Mahasiswa. Jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>
