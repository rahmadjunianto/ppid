<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
        }
        .footer {
            background-color: #6c757d;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 14px;
        }
        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .info-table th,
        .info-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .info-table th {
            background-color: #e9ecef;
            font-weight: bold;
            width: 30%;
        }
        .message-content {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 15px 0;
            border-radius: 0 5px 5px 0;
        }
        .alert {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pesan Kontak Baru</h1>
        <p>PPID - Pejabat Pengelola Informasi dan Dokumentasi</p>
    </div>

    <div class="content">
        <div class="alert">
            <strong>Pemberitahuan:</strong> Anda menerima pesan baru melalui formulir kontak website PPID.
        </div>

        <table class="info-table">
            <tr>
                <th>Nama</th>
                <td>{{ $name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td><a href="mailto:{{ $email }}">{{ $email }}</a></td>
            </tr>
            @if($phone)
            <tr>
                <th>Telepon</th>
                <td>{{ $phone }}</td>
            </tr>
            @endif
            <tr>
                <th>Subjek</th>
                <td><strong>{{ $subject }}</strong></td>
            </tr>
            <tr>
                <th>Waktu</th>
                <td>{{ $timestamp }}</td>
            </tr>
        </table>

        <h3>Pesan:</h3>
        <div class="message-content">
            {{ $messageContent }}
        </div>

        <div class="alert">
            <strong>Tindak Lanjut:</strong><br>
            • Harap merespons pesan ini dalam 1-2 hari kerja<br>
            • Gunakan tombol "Reply" untuk membalas langsung ke pengirim<br>
            • Dokumentasikan komunikasi sesuai prosedur yang berlaku
        </div>
    </div>

    <div class="footer">
        <p>
            Email ini dikirim otomatis dari sistem PPID<br>
            <strong>Jangan membalas email ini</strong><br>
            Untuk merespons, gunakan alamat email pengirim: {{ $email }}
        </p>
    </div>
</body>
</html>
