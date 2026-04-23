<?php

namespace App\Exports;

use App\Models\SurveySkmSpak;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\PatternFill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Http\Request;

class SurveySkmSpakExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = SurveySkmSpak::query();

        if ($this->request) {
            // Apply same filters as index
            if ($this->request->filled('kategori_responden')) {
                $query->where('kategori_responden', $this->request->kategori_responden);
            }

            if ($this->request->filled('jenis_pelayanan')) {
                $query->where('jenis_pelayanan', $this->request->jenis_pelayanan);
            }

            if ($this->request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $this->request->from_date);
            }
            if ($this->request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $this->request->to_date);
            }
        }

        return $query->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Kelamin',
            'Usia',
            'Pendidikan',
            'Pekerjaan',
            'Kategori',
            'Unit Kerja',
            'Jabatan',
            'Jenis Pelayanan',
            'Skor SKM',
            'U1 Persyaratan',
            'U2 Prosedur',
            'U3 Waktu',
            'U4 Biaya',
            'U5 Hasil',
            'U6 Kompetensi',
            'U7 Perilaku',
            'U8 Pengaduan',
            'U9 Sarana',
            'Skor SPAK',
            'I1 Diskriminasi',
            'I2 Curang',
            'I3 Imbalan',
            'I4 Percaloan',
            'I5 Pungli',
            'Kritik/Saran',
            'Tanggal',
            'IP Address'
        ];
    }

    public function map($survey): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $survey->jenis_kelamin,
            $survey->usia,
            $survey->pendidikan_terakhir,
            $survey->pekerjaan,
            $survey->kategori_responden,
            $survey->unit_kerja,
            $survey->jabatan,
            $survey->jenis_pelayanan,
            $survey->getSkmAverage() ?? 'N/A',
            $survey->u1_persyaratan ?? '-',
            $survey->u2_prosedur ?? '-',
            $survey->u3_waktu_pelayanan ?? '-',
            $survey->u4_biaya_tarif ?? '-',
            $survey->u5_hasil_pelayanan ?? '-',
            $survey->u6_kompetensi_petugas ?? '-',
            $survey->u7_perilaku_petugas ?? '-',
            $survey->u8_pengaduan ?? '-',
            $survey->u9_sarana_prasarana ?? '-',
            $survey->getSpakAverage() ?? 'N/A',
            $survey->i1_tidak_diskriminatif ?? '-',
            $survey->i2_tidak_curang ?? '-',
            $survey->i3_tidak_imbalan ?? '-',
            $survey->i4_tidak_percaloan ?? '-',
            $survey->i5_tidak_pungli ?? '-',
            substr($survey->kritik_saran ?? '', 0, 100),
            $survey->created_at->format('Y-m-d H:i'),
            $survey->ip_address ?? '-'
        ];
    }

    public function styles($sheet)
    {
        $headerFill = new PatternFill(
            PatternFill::FILL_SOLID,
            '1e5631'
        );
        $headerFont = new Font([
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
            'size' => 11
        ]);

        $sheet->getStyle('1')->setFill($headerFill);
        $sheet->getStyle('1')->setFont($headerFont);
        $sheet->getStyle('1')->setAlignment(
            new Alignment(Alignment::HORIZONTAL_CENTER, Alignment::VERTICAL_CENTER, 0, true)
        );

        // Auto-size columns
        foreach (range('A', $sheet->getHighestColumn()) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Freeze header row
        $sheet->freezePane('A2');

        return [];
    }
}
