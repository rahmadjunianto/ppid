<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terima Kasih - PPID</title>
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
            background-color: #28a745;
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
        .info-box {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .contact-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #007bff;
        }
        .message-summary {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .contact-details {
            margin: 20px 0;
        }
        .contact-details h4 {
            color: #007bff;
            margin-bottom: 10px;
        }
        .contact-method {
            display: flex;
            align-items: center;
            margin: 8px 0;
        }
        .contact-method i {
            width: 20px;
            margin-right: 10px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Terima Kasih!</h1>
        <p>Pesan Anda telah berhasil dikirim</p>
    </div>

    <div class="content">
        <div class="info-box">
            <strong>Halo {{ $name }},</strong><br>
            Terima kasih telah menghubungi PPID. Pesan Anda telah kami terima dan akan diproses sesuai dengan prosedur yang berlaku.
        </div>

        <div class="message-summary">
            <h3>Ringkasan Pesan Anda:</h3>
            <p><strong>Subjek:</strong> {{ $subject }}</p>
            <p><strong>Waktu Pengiriman:</strong> {{ $timestamp }}</p>
            <p><strong>Email:</strong> {{ $email }}</p>
        </div>

        <div class="contact-info">
            <h3>Apa yang terjadi selanjutnya?</h3>
            <ul>
                <li><strong>Konfirmasi Penerimaan:</strong> Email ini mengkonfirmasi bahwa pesan Anda telah diterima</li>
                <li><strong>Pemrosesan:</strong> Tim kami akan meninjau pesan Anda dalam 1-2 hari kerja</li>
                <li><strong>Respons:</strong> Kami akan mengirim respons ke email: <strong>{{ $email }}</strong></li>
                <li><strong>Tindak Lanjut:</strong> Jika diperlukan, kami akan menghubungi Anda untuk informasi tambahan</li>
            </ul>
        </div>

        <div class="contact-details">
            <h4>Informasi Kontak PPID:</h4>

            <div class="contact-method">
                <span>📍</span>
                <span>Jl. Raya No. 123, Jakarta Pusat 10110</span>
            </div>

            <div class="contact-method">
                <span>📞</span>
                <span>Telepon: (021) 1234-5678</span>
            </div>

            <div class="contact-method">
                <span>📠</span>
                <span>Fax: (021) 1234-5679</span>
            </div>

            <div class="contact-method">
                <span>✉️</span>
                <span>Email: info@ppid.go.id</span>
            </div>

            <div class="contact-method">
                <span>🕒</span>
                <span>Jam Operasional: Senin-Kamis 08:00-16:00, Jumat 08:00-16:30</span>
            </div>
        </div>

        <div class="info-box">
            <strong>Catatan Penting:</strong><br>
            • Untuk keperluan mendesak, silakan hubungi hotline 24/7: 0800-1234-5678<br>
            • Pastikan email dari domain @ppid.go.id tidak masuk ke folder spam<br>
            • Simpan email ini sebagai bukti komunikasi dengan PPID
        </div>
    </div>

    <div class="footer">
        <p>
            <strong>PPID - Pejabat Pengelola Informasi dan Dokumentasi</strong><br>
            Melayani dengan transparansi dan akuntabilitas<br>
            Website: <a href="https://ppid.go.id" style="color: #fff;">ppid.go.id</a>
        </p>
    </div>
</body>
</html>
