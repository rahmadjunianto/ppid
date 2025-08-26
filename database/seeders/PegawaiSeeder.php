<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pegawaiData = [
            // Kepala Kantor
            [
                'nama' => 'ABDUL RAHMAN S.Ag, M.PdI',
                'jabatan' => 'Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'Kantor',
                'urutan' => 1
            ],

            // KUA Leaders
            [
                'nama' => 'KHOIRUN NI`AM S.Pd.I, SE',
                'jabatan' => 'Penghulu Ahli Pertama / Kepala',
                'golongan' => 'III/b',
                'unit_kerja' => 'KUA Kec. Bagor',
                'urutan' => 10
            ],
            [
                'nama' => 'MASHURI S.Th.I',
                'jabatan' => 'Penghulu Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'KUA Kec. Baron',
                'urutan' => 11
            ],
            [
                'nama' => 'BAMBANG WIONO S.Sos.I',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Berbek'
            ],
            [
                'nama' => 'IMAM MAHMUD S.Ag, M.HI',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Gondang'
            ],
            [
                'nama' => 'SAMSUDIN ALWI S.Pd.I',
                'jabatan' => 'Penghulu Ahli Pertama / Kepala',
                'golongan' => 'III/b',
                'unit_kerja' => 'KUA Kec. Jatikalen'
            ],
            [
                'nama' => 'MASHURI S.Th.I',
                'jabatan' => 'Penghulu Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'KUA Kec. Kertosono'
            ],
            [
                'nama' => 'SODIK AFFANDI S.E.Sy',
                'jabatan' => 'Penghulu Ahli Pertama / Kepala',
                'golongan' => 'III/a',
                'unit_kerja' => 'KUA Kec. Lengkong'
            ],
            [
                'nama' => 'QOMARUDDIN S.Ag, M.Pd.I',
                'jabatan' => 'Penghulu Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'KUA Kec. Loceret'
            ],
            [
                'nama' => 'NUR HUDHA S.Ag',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Nganjuk'
            ],
            [
                'nama' => 'MIFTAHHUL HUDA S.Pd.I ,M.Pd',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/c',
                'unit_kerja' => 'KUA Kec. Ngetos'
            ],
            [
                'nama' => 'IMAM MAHMUD S.Ag, M.HI',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Ngluyu'
            ],
            [
                'nama' => 'ISA MUSTOFA S.Pd.I',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/c',
                'unit_kerja' => 'KUA Kec. Ngronggot'
            ],
            [
                'nama' => 'MISTURAN ADIPATI S.Ag',
                'jabatan' => 'Penghulu Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'KUA Kec. Pace'
            ],
            [
                'nama' => 'Drs. NURUL MUBIN MM',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Patianrowo'
            ],
            [
                'nama' => 'MOH . SYAHID SE,Sy',
                'jabatan' => 'Penghulu Ahli Pertama / Kepala',
                'golongan' => 'III/b',
                'unit_kerja' => 'KUA Kec. Prambon'
            ],
            [
                'nama' => 'NUR ALIFI S.Ag',
                'jabatan' => 'Penghulu Ahli Pertama / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Rejoso'
            ],
            [
                'nama' => 'AMNAN KHOIR S.Th.I, M.HI',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Sawahan'
            ],
            [
                'nama' => 'MOH. SYAMSUL FU`AD S.H.I',
                'jabatan' => 'Penghulu Ahli Pertama / Kepala',
                'golongan' => 'III/a',
                'unit_kerja' => 'KUA Kec. Sukomoro'
            ],
            [
                'nama' => 'MASRUKIN S.Ag',
                'jabatan' => 'Penghulu Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'KUA Kec. Tanjunganom'
            ],
            [
                'nama' => 'KHOIRUN NI`AM S.Pd.I, SE',
                'jabatan' => 'Penghulu Ahli Pertama / Kepala',
                'golongan' => 'III/b',
                'unit_kerja' => 'KUA Kec. Wilangan'
            ],
            [
                'nama' => 'MUH ZUHAL S.Ag.,M.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MAN 1 Nganjuk'
            ],
            [
                'nama' => 'KASNAN S,Ag',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MAN 2 Nganjuk'
            ],
            [
                'nama' => 'BADRU TAMAM S.Pd',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MAN 3 Nganjuk'
            ],
            [
                'nama' => 'IQBIL QAULY S.Pd',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MIN 1 Nganjuk'
            ],
            [
                'nama' => 'Drs. AKHMAD SOFYAN',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MIN 10 Nganjuk'
            ],
            [
                'nama' => 'MUHAMAD RIFAI M.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MIN 11 Nganjuk'
            ],
            [
                'nama' => 'Drs. ALI FAISOL',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MIN 2 Nganjuk'
            ],
            [
                'nama' => 'Drs. ASMUNI M.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MIN 3 Nganjuk'
            ],
            [
                'nama' => 'BINTI ROSYIDAH  M.Pd.I',
                'jabatan' => 'Guru Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'MIN 4 Nganjuk'
            ],
            [
                'nama' => 'Dra. MUBAROKAH M.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MIN 5 Nganjuk'
            ],
            [
                'nama' => 'ENY JUNAIDAH S.Pd',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MIN 6 Nganjuk'
            ],
            [
                'nama' => 'BINTI SHOKHIFUL NI`MAH S.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MIN 7 Nganjuk'
            ],
            [
                'nama' => 'SITI ALBADRIYAH M.Pd.I',
                'jabatan' => 'Guru Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'MIN 8 Nganjuk'
            ],
            [
                'nama' => 'BINTI ROSYIDAH M.Pd.I',
                'jabatan' => 'Guru Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'MIN 8 Nganjuk'
            ],
            [
                'nama' => 'IQBIL QAULY S.Pd',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MIN 9 Nganjuk'
            ],
            [
                'nama' => 'Dra. IDA ROSIDA MAIMUN M.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/c',
                'unit_kerja' => 'MTsN 1 Nganjuk'
            ],
            [
                'nama' => 'Drs. ARIFIN',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MTsN 10 Nganjuk'
            ],
            [
                'nama' => 'MOH. MASRUKIN M.Pd',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MTsN 2 Nganjuk'
            ],
            [
                'nama' => 'SUNDOSIN, S.Ag, M.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MTsN 3 Nganjuk'
            ],
            [
                'nama' => 'Dra. S WAHIBAH',
                'jabatan' => 'Guru Ahli Muda / Kepala',
                'golongan' => 'III/d',
                'unit_kerja' => 'MTsN 4 Nganjuk'
            ],
            [
                'nama' => 'HADI SAPUAN S.Pd',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MTsN 5 Nganjuk'
            ],
            [
                'nama' => 'SUNDOSIN S.Ag, M.Pd.I',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MTsN 6 Nganjuk'
            ],
            [
                'nama' => 'MOCHAMMAD ABDUL RASYID M.Pd.',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MTsN 7 Nganjuk'
            ],
            [
                'nama' => 'AFIFUDIN S.Ag',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'MTsN 8 Nganjuk'
            ],
            [
                'nama' => 'MOCHAMAD HERNUDIN S.Ag',
                'jabatan' => 'Guru Ahli Madya / Kepala',
                'golongan' => 'IV/b',
                'unit_kerja' => 'MTsN 9 Nganjuk'
            ],
            [
                'nama' => 'DAWUT MAULAN S.Pd',
                'jabatan' => 'Kepala Seksi',
                'golongan' => 'IV/a',
                'unit_kerja' => 'Seksi Bimbingan Masyarakat Islam'
            ],
            [
                'nama' => 'Drs. IMAM MUJAIB M.HI',
                'jabatan' => 'Kepala Seksi',
                'golongan' => 'IV/a',
                'unit_kerja' => 'Seksi Pendidikan Agama Islam'
            ],
            [
                'nama' => 'MUKSIN M.Pd.I.',
                'jabatan' => 'Kepala Seksi',
                'golongan' => 'IV/a',
                'unit_kerja' => 'Seksi Pendidikan Diniyah dan Pondok Pesantren'
            ],
            [
                'nama' => 'SUTOPO S.Ag, M.Pd.I',
                'jabatan' => 'Pengawas sebagai Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'Seksi Pendidikan Madrasah'
            ],
            [
                'nama' => 'ZAINAL ABIDIN HANIF KAMALODIN S.Sos.,S.Pd.I., MM',
                'jabatan' => 'Kepala Seksi',
                'golongan' => 'IV/a',
                'unit_kerja' => 'Seksi Penyelenggaraan Haji dan Umrah'
            ],
            [
                'nama' => 'FARID WAJDI S.Ag.,MM',
                'jabatan' => 'Kepala',
                'golongan' => 'IV/a',
                'unit_kerja' => 'Sub Bagian Tata Usaha'
            ]
        ];

        foreach ($pegawaiData as $data) {
            Pegawai::create($data);
        }
    }
}
