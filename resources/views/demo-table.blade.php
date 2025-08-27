<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Tabel PPID yang Menarik</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        /* Modern Table Styles */
        .table-container {
            overflow-x: auto;
            margin: 25px 0;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .modern-table thead tr {
            background: linear-gradient(135deg, #1e5631, #2d8f47);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .modern-table thead tr::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .modern-table:hover thead tr::before {
            left: 100%;
        }

        .modern-table th {
            padding: 18px 20px;
            text-align: left;
            font-size: 16px;
            font-weight: 600;
            border: none;
            position: relative;
        }

        .modern-table th.center {
            text-align: center;
            min-width: 150px;
        }

        .modern-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        .modern-table tbody tr:nth-child(odd) {
            background-color: #f8fffe;
        }

        .modern-table tbody tr:nth-child(even) {
            background-color: white;
        }

        .modern-table tbody tr:hover {
            background: linear-gradient(135deg, #f0fff4, #e6fffa) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(30, 86, 49, 0.15);
        }

        .modern-table td {
            padding: 16px 20px;
            border: none;
            font-size: 15px;
            color: #2d3748;
        }

        .modern-table td.center {
            text-align: center;
        }

        .info-title {
            color: #1e5631;
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }

        .info-desc {
            color: #718096;
            font-size: 13px;
            display: block;
        }

        .action-btn {
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translate(-50%, -50%);
        }

        .action-btn:hover::before {
            width: 200px;
            height: 200px;
        }

        .action-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-blue {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            box-shadow: 0 2px 8px rgba(66, 153, 225, 0.3);
        }

        .btn-blue:hover {
            background: linear-gradient(135deg, #3182ce, #2c5282);
        }

        .btn-orange {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            box-shadow: 0 2px 8px rgba(237, 137, 54, 0.3);
        }

        .btn-orange:hover {
            background: linear-gradient(135deg, #dd6b20, #c05621);
        }

        .btn-green {
            background: linear-gradient(135deg, #48bb78, #38a169);
            box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3);
        }

        .btn-green:hover {
            background: linear-gradient(135deg, #38a169, #2f855a);
        }

        .btn-purple {
            background: linear-gradient(135deg, #9f7aea, #805ad5);
            box-shadow: 0 2px 8px rgba(159, 122, 234, 0.3);
        }

        .btn-purple:hover {
            background: linear-gradient(135deg, #805ad5, #6b46c1);
        }

        .btn-red {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            box-shadow: 0 2px 8px rgba(245, 101, 101, 0.3);
        }

        .btn-red:hover {
            background: linear-gradient(135deg, #e53e3e, #c53030);
        }

        .page-title {
            color: #1e5631;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 3px solid #1e5631;
            padding-bottom: 15px;
            position: relative;
        }

        .page-title::before {
            content: '📋';
            margin-right: 10px;
        }

        .info-box {
            background: linear-gradient(135deg, #e7f3ff, #f0f9ff);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #b8daff;
            text-align: center;
        }

        .info-box p {
            font-size: 16px;
            color: #2c5282;
            margin: 0;
        }

        .info-box::before {
            content: '🏛️';
            margin-right: 10px;
        }

        /* Animation */
        .modern-table {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .modern-table {
                font-size: 14px;
            }

            .modern-table th,
            .modern-table td {
                padding: 12px 8px;
            }

            .page-title {
                font-size: 24px;
            }
        }

        /* Custom scrollbar */
        .table-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #1e5631, #2d8f47);
            border-radius: 4px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #2d8f47, #1e5631);
        }

        .demo-info {
            background: linear-gradient(135deg, #fff7ed, #fef3c7);
            border-left: 6px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.15);
        }

        .demo-info h3 {
            color: #92400e;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .demo-info p {
            color: #78350f;
            margin: 0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">Informasi Tersedia Setiap Saat</h1>

        <div class="info-box">
            <p><strong>Berikut adalah daftar informasi publik yang tersedia setiap saat di PPID Kemenag Nganjuk</strong></p>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>
                            <span style="display: flex; align-items: center;">
                                📄 Nama Informasi Publik
                            </span>
                        </th>
                        <th class="center">
                            <span style="display: flex; align-items: center; justify-content: center;">
                                ⚡ Aksi
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="info-title">📋 Daftar Informasi Publik</span>
                            <span class="info-desc">Katalog lengkap informasi yang dapat diakses publik</span>
                        </td>
                        <td class="center">
                            <a href="#" class="action-btn btn-blue">
                                👀 Lihat Detail
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-title">🚫 Informasi yang Dikecualikan</span>
                            <span class="info-desc">Daftar informasi yang tidak dapat diakses publik</span>
                        </td>
                        <td class="center">
                            <a href="#" class="action-btn btn-orange">
                                📋 Lihat Detail
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-title">📖 Pedoman Pengelolaan Administrasi</span>
                            <span class="info-desc">Panduan tata kelola administrasi perkantoran</span>
                        </td>
                        <td class="center">
                            <a href="#" class="action-btn btn-green">
                                📥 Download PDF
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-title">🏢 Pedoman Pengelolaan Organisasi</span>
                            <span class="info-desc">Struktur dan tata kelola organisasi</span>
                        </td>
                        <td class="center">
                            <a href="#" class="action-btn btn-purple">
                                📥 Download PDF
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="info-title">📊 Statistik Kepegawaian</span>
                            <span class="info-desc">Data statistik pegawai dan kepegawaian</span>
                        </td>
                        <td class="center">
                            <a href="#" class="action-btn btn-red">
                                📈 Lihat Data
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="demo-info">
            <h3>🎨 Fitur Tabel yang Menarik</h3>
            <p>
                <strong>✨ Hover Effects:</strong> Tabel memiliki efek hover yang smooth<br>
                <strong>🎨 Gradient Headers:</strong> Header menggunakan gradient warna hijau Kemenag<br>
                <strong>📱 Responsive Design:</strong> Tabel otomatis responsive di mobile<br>
                <strong>🌊 Smooth Animations:</strong> Animasi yang halus saat interaksi<br>
                <strong>🎯 Color-coded Buttons:</strong> Setiap aksi memiliki warna yang berbeda<br>
                <strong>💡 Modern Typography:</strong> Font dan spacing yang modern
            </p>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.action-btn');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Create ripple effect
                    const ripple = document.createElement('div');
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255,255,255,0.6)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.left = (e.offsetX - 10) + 'px';
                    ripple.style.top = (e.offsetY - 10) + 'px';
                    ripple.style.width = '20px';
                    ripple.style.height = '20px';

                    this.style.position = 'relative';
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>

    <style>
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</body>
</html>
