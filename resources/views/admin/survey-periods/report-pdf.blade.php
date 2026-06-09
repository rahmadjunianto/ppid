<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan IKM & SPAK {{ $period->getPeriodLabel() }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #1a5f7a;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 16px;
            color: #1a5f7a;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #666;
        }
        
        .info-box {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .info-box h3 {
            font-size: 12px;
            color: #1a5f7a;
            margin-bottom: 8px;
            border-bottom: 1px solid #1a5f7a;
            padding-bottom: 5px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            flex: 1;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 13px;
            color: #1a5f7a;
            border-bottom: 2px solid #1a5f7a;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }
        
        table th, table td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
        }
        
        table th {
            background: #1a5f7a;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-info {
            background: #17a2b8;
            color: white;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #333;
        }
        
        .badge-danger {
            background: #dc3545;
            color: white;
        }
        
        .follow-up-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            background: #fff;
        }
        
        .follow-up-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        
        .follow-up-title {
            font-weight: bold;
            color: #1a5f7a;
        }
        
        .follow-up-body {
            font-size: 10px;
        }
        
        .follow-up-row {
            display: flex;
            margin-bottom: 3px;
        }
        
        .signatory-box {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        
        .signatory-table {
            width: 100%;
            margin-top: 30px;
        }
        
        .signatory-table td {
            text-align: center;
            vertical-align: bottom;
            height: 80px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
            text-align: center;
        }
        
        @page {
            margin: 20mm 15mm;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN HASIL SURVEI</h1>
        <h2>Indeks Kepuasan Masyarakat (IKM) & Survei Penilaian Anti Korupsi (SPAK)</h2>
        <p>Periode: {{ $period->getPeriodLabel() }}</p>
        <p>Tanggal Survei: {{ $period->survey_start_date->format('d/m/Y') }} - {{ $period->survey_end_date->format('d/m/Y') }}</p>
    </div>

    <!-- Info Dasar -->
    <div class="info-box">
        <h3>Informasi Dasar Survei</h3>
        <div class="info-row">
            <div class="info-label">Tahun:</div>
            <div class="info-value">{{ $period->year }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Periode:</div>
            <div class="info-value">{{ $period->getQuarterLabel() }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tipe Survei:</div>
            <div class="info-value">
                @if($period->survey_type == 'ikm')
                    Indeks Kepuasan Masyarakat (IKM)
                @elseif($period->survey_type == 'spak')
                    Survei Penilaian Anti Korupsi (SPAK)
                @else
                    IKM & SPAK
                @endif
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Total Responden:</div>
            <div class="info-value">{{ number_format($period->total_respondents) }} orang</div>
        </div>
        <div class="info-row">
            <div class="info-label">Target Responden:</div>
            <div class="info-value">{{ number_format($period->target_respondents) }} orang</div>
        </div>
        <div class="info-row">
            <div class="info-label">Response Rate:</div>
            <div class="info-value">{{ number_format($period->response_rate, 2) }}%</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                @if($period->is_published)
                    <span class="badge badge-success">DIPUBLIKASIKAN</span>
                @else
                    <span class="badge badge-warning">DRAFT</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Hasil IKM -->
    @if($period->ikm_value)
    <div class="section">
        <h3 class="section-title">HASIL INDEKS KEPUASAN MASYARAKAT (IKM)</h3>
        <table>
            <tr>
                <th width="30%">Indikator</th>
                <th width="70%">Detail</th>
            </tr>
            <tr>
                <td><strong>Nilai IKM</strong></td>
                <td><strong style="font-size: 16px;">{{ number_format($period->ikm_value, 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Kategori</strong></td>
                <td>
                    <span class="badge badge-{{ $period->ikm_category == 'A' ? 'success' : ($period->ikm_category == 'B' ? 'info' : 'warning') }}">
                        {{ $period->ikm_category }}
                    </span>
                    - {{ $period->ikm_category_label }}
                </td>
            </tr>
            <tr>
                <td><strong>Mutu Pelayanan</strong></td>
                <td>{{ $period->ikm_category_label }}</td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Hasil SPAK -->
    @if($period->spak_value)
    <div class="section">
        <h3 class="section-title">HASIL SURVEI PENILAIAN ANTI KORUPSI (SPAK)</h3>
        <table>
            <tr>
                <th width="30%">Indikator</th>
                <th width="70%">Detail</th>
            </tr>
            <tr>
                <td><strong>Nilai SPAK</strong></td>
                <td><strong style="font-size: 16px;">{{ number_format($period->spak_value, 2) }}</strong></td>
            </tr>
            <tr>
                <td><strong>Kategori</strong></td>
                <td>
                    <span class="badge badge-{{ $period->spak_category == 'A' ? 'success' : ($period->spak_category == 'B' ? 'info' : 'warning') }}">
                        {{ $period->spak_category }}
                    </span>
                    - {{ $period->spak_category_label }}
                </td>
            </tr>
            <tr>
                <td><strong>Mutu Pelayanan</strong></td>
                <td>{{ $period->spak_category_label }}</td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Tindak Lanjut -->
    @if($followUps && $followUps->count() > 0)
    <div class="section">
        <h3 class="section-title">LAPORAN TINDAK LANJUT PERBAIKAN PELAYANAN</h3>
        @foreach($followUps as $followUp)
        <div class="follow-up-item">
            <div class="follow-up-header">
                <span class="follow-up-title">{{ $followUp->title }}</span>
                <span class="badge badge-{{ $followUp->status == 'completed' ? 'success' : ($followUp->status == 'in_progress' ? 'info' : 'warning') }}">
                    {{ ucfirst(str_replace('_', ' ', $followUp->status)) }}
                </span>
            </div>
            <div class="follow-up-body">
                @if($followUp->description)
                <p><strong>Deskripsi:</strong> {{ $followUp->description }}</p>
                @endif
                @if($followUp->action_plan)
                <p><strong>Rencana Tindakan:</strong> {{ $followUp->action_plan }}</p>
                @endif
                @if($followUp->responsible_unit)
                <p><strong>Unit Responsible:</strong> {{ $followUp->responsible_unit }}</p>
                @endif
                @if($followUp->PIC)
                <p><strong>PIC:</strong> {{ $followUp->PIC }}</p>
                @endif
                @if($followUp->target_date)
                <p><strong>Target:</strong> {{ \Carbon\Carbon::parse($followUp->target_date)->format('d/m/Y') }}</p>
                @endif
                @if($followUp->result)
                <p><strong>Hasil:</strong> {{ $followUp->result }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Tanda Tangan -->
    <div class="signatory-box">
        <table class="signatory-table">
            <tr>
                <td width="50%">
                    <p>Mengetahui,</p>
                    <p><strong>{{ $period->signatory_position ?? 'Pimpinan Instansi' }}</strong></p>
                    <br><br><br>
                    <p><strong><u>{{ $period->signatory_name ?? '................................' }}</u></strong></p>
                    <p>NIP. {{ $period->signatory_nip ?? '................................' }}</p>
                </td>
                <td width="50%">
                    <p>Nganjuk, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                    <p><strong>Tim Survei</strong></p>
                    <br><br><br>
                    <p><strong><u>................................</u></strong></p>
                    <p>NIP. ................................</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Informasi IKM & SPAK</p>
        <p>Generated: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
