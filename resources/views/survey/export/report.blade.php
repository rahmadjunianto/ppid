<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Survei IKM dan SPAK</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        h1 { text-align: center; font-size: 16px; }
        h2 { font-size: 14px; border-bottom: 2px solid #333; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .header-table { margin-bottom: 30px; }
        .info-box { background-color: #f9f9f9; padding: 15px; border: 1px solid #ddd; margin-bottom: 20px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 11px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-warning { background-color: #ffc107; color: #333; }
    </style>
</head>
<body>
    <h1>LAPORAN HASIL SURVEI<br>INDEKS KEPUASAN MASYARAKAT (IKM) DAN<br>SURVEI PENILAIAN ANTI KORUPSI (SPAK)</h1>
    
    <div class="info-box">
        <table class="header-table">
            <tr>
                <td width="30%"><strong>Periode</strong></td>
                <td>: {{ $period->getPeriodLabel() }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Survei</strong></td>
                <td>: {{ \Carbon\Carbon::parse($period->survey_start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($period->survey_end_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Jumlah Responden</strong></td>
                <td>: {{ $period->total_respondents }} orang</td>
            </tr>
            <tr>
                <td><strong>Target Responden</strong></td>
                <td>: {{ $period->target_respondents }} orang</td>
            </tr>
            <tr>
                <td><strong>Tingkat Respons</strong></td>
                <td>: {{ $period->response_rate ?? number_format(($period->total_respondents / $period->target_respondents) * 100, 2) }}%</td>
            </tr>
            <tr>
                <td><strong>Dipublikasikan</strong></td>
                <td>: {{ $period->published_at ? \Carbon\Carbon::parse($period->published_at)->format('d/m/Y') : 'Belum dipublikasikan' }}</td>
            </tr>
        </table>
    </div>

    @if($type === 'all' || $type === 'ikm')
    <h2>A. HASIL INDEKS KEPUASAN MASYARAKAT (IKM)</h2>
    <table>
        <thead>
            <tr>
                <th class="text-center">Nilai IKM</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"><strong>{{ number_format($period->ikm_value, 2) }}</strong></td>
                <td class="text-center">
                    <span class="badge badge-success">{{ $period->ikm_category_label ?? 'Sangat Baik' }}</span>
                </td>
                <td>Indeks Kepuasan Masyarakat pada kategori {{ $period->ikm_category_label ?? 'Sangat Baik' }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if($type === 'all' || $type === 'spak')
    <h2>B. HASIL SURVEI PENILAIAN ANTI KORUPSI (SPAK)</h2>
    <table>
        <thead>
            <tr>
                <th class="text-center">Nilai SPAK</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"><strong>{{ number_format($period->spak_value, 2) }}</strong></td>
                <td class="text-center">
                    <span class="badge badge-success">{{ $period->spak_category_label ?? 'Sangat Baik' }}</span>
                </td>
                <td>Perilaku Anti Korupsi pada kategori {{ $period->spak_category_label ?? 'Sangat Baik' }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if($type === 'all' || $type === 'followup')
    <h2>C. RENCANA TINDAK LANJUT</h2>
    @if($followUps->count() > 0)
    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="25%">Judul Tindakan</th>
                <th width="30%">Rencana Tindakan</th>
                <th width="15%">Unit Kerja</th>
                <th class="text-center" width="10%">Target</th>
                <th class="text-center" width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($followUps as $key => $followUp)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $followUp->title }}</td>
                <td>{{ $followUp->action_plan }}</td>
                <td>{{ $followUp->responsible_unit ?? '-' }}</td>
                <td class="text-center">{{ $followUp->target_date ? \Carbon\Carbon::parse($followUp->target_date)->format('d/m/Y') : '-' }}</td>
                <td class="text-center">
                    <span class="badge {{ $followUp->status === 'completed' ? 'badge-success' : ($followUp->status === 'in_progress' ? 'badge-warning' : 'badge-info') }}">
                        {{ ucfirst(str_replace('_', ' ', $followUp->status)) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Tidak ada rencana tindak lanjut untuk periode ini.</p>
    @endif
    @endif

    <br><br>
    <table style="width: 100%; margin-top: 50px;">
        <tr>
            <td width="60%"></td>
            <td class="text-center">
                <p>Mengetahui,</p>
                <p style="margin-top: 60px;">{{ $period->signatory_name ?? 'Kepala Kantor' }}</p>
                <p>NIP. {{ $period->signatory_nip ?? '-' }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
