@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.surveys-skm-spak.index') }}">Survey SKM & SPAK</a></li>
                    <li class="breadcrumb-item active">Detail Responden #{{ $survey->id }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-poll me-2"></i> Detail Responden #{{ $survey->id }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.surveys-skm-spak.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal">
                            <i class="fas fa-trash mr-2"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Skor SKM</span>
                    <span class="info-box-number" style="font-size: 1.5rem;">{{ $statistics['skm_average'] ?? 'N/A' }}/4</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-shield-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Skor SPAK</span>
                    <span class="info-box-number" style="font-size: 1.5rem;">{{ $statistics['spak_average'] ?? 'N/A' }}/4</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fas fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tanggal Respon</span>
                    <span class="info-box-number" style="font-size: 0.9rem;">{{ $survey->created_at->locale('id')->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Demografis -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i> Data Demografis Responden
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Jenis Kelamin:</strong>
                            <p class="text-muted">{{ $survey->jenis_kelamin }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Usia:</strong>
                            <p class="text-muted">{{ $survey->usia }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Pendidikan Terakhir:</strong>
                            <p class="text-muted">{{ $survey->pendidikan_terakhir }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Pekerjaan:</strong>
                            <p class="text-muted">{{ $survey->pekerjaan }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Kategori Responden:</strong>
                            <p><span class="badge {{ strpos($survey->kategori_responden, 'Internal') !== false ? 'badge-primary' : 'badge-info' }}">{{ $survey->kategori_responden }}</span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Unit Kerja:</strong>
                            <p class="text-muted">{{ $survey->unit_kerja }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Jabatan:</strong>
                            <p class="text-muted">{{ $survey->jabatan }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Jenis Pelayanan:</strong>
                            <p class="text-muted">{{ $survey->jenis_pelayanan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SKM Scores -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i> Survei Kepuasan Masyarakat (SKM)
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Unsur</th>
                                <th>Pertanyaan</th>
                                <th width="150">Skor</th>
                                <th>Label</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>U1</strong></td>
                                <td>Persyaratan pelayanan yang diinformasikan sesuai dengan persyaratan yang ditetapkan unit layanan ini</td>
                                <td><span class="badge badge-info">{{ $survey->u1_persyaratan ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u1_persyaratan) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U2</strong></td>
                                <td>Informasi mengenai prosedur/alur pelayanan mudah dipahami dan diikuti serta tersedia dalam media elektronik maupun non-elektronik</td>
                                <td><span class="badge badge-info">{{ $survey->u2_prosedur ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u2_prosedur) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U3</strong></td>
                                <td>Jangka waktu penyelesaian pelayanan yang diterima Bapak/Ibu sesuai dengan yang ditetapkan unit layanan ini</td>
                                <td><span class="badge badge-info">{{ $survey->u3_waktu_pelayanan ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u3_waktu_pelayanan) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U4</strong></td>
                                <td>Tarif/biaya pelayanan yang dibayarkan pada unit layanan ini sesuai dengan tarif/biaya yang ditetapkan</td>
                                <td><span class="badge badge-info">{{ $survey->u4_biaya_tarif ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u4_biaya_tarif) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U5</strong></td>
                                <td>Hasil pelayanan yang Bapak/Ibu terima pada unit layanan ini sesuai dengan ketentuan yang ditetapkan</td>
                                <td><span class="badge badge-info">{{ $survey->u5_hasil_pelayanan ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u5_hasil_pelayanan) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U6</strong></td>
                                <td>Petugas pelayanan memiliki pengetahuan dan keahlian sesuai dengan jenis layanan yang Bapak/Ibu butuhkan pada unit layanan ini</td>
                                <td><span class="badge badge-info">{{ $survey->u6_kompetensi_petugas ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u6_kompetensi_petugas) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U7</strong></td>
                                <td>Petugas pelayanan pada unit layanan ini melayani keperluan Bapak/Ibu dengan sopan dan ramah</td>
                                <td><span class="badge badge-info">{{ $survey->u7_perilaku_petugas ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u7_perilaku_petugas) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U8</strong></td>
                                <td>Layanan konsultasi dan pengaduan yang disediakan unit layanan ini mudah digunakan/diakses</td>
                                <td><span class="badge badge-info">{{ $survey->u8_pengaduan ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u8_pengaduan) }}</td>
                            </tr>
                            <tr>
                                <td><strong>U9</strong></td>
                                <td>Sarana dan prasarana pendukung pelayanan/sistem pelayanan online yang disediakan unit layanan ini memberikan kemudahan/mudah digunakan</td>
                                <td><span class="badge badge-info">{{ $survey->u9_sarana_prasarana ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSkmScoreLabel($survey->u9_sarana_prasarana) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-info mt-3">
                        <strong>Rata-rata SKM:</strong> {{ $statistics['skm_average'] ?? 'N/A' }}/4.0
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SPAK Scores -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt mr-2"></i> Survei Persepsi Anti Korupsi (SPAK)
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Unsur</th>
                                <th>Pertanyaan</th>
                                <th width="150">Skor</th>
                                <th>Label</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>I1</strong></td>
                                <td>Tidak ada diskriminasi pelayanan pada unit layanan ini</td>
                                <td><span class="badge badge-warning">{{ $survey->i1_tidak_diskriminatif ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSpakScoreLabel($survey->i1_tidak_diskriminatif) }}</td>
                            </tr>
                            <tr>
                                <td><strong>I2</strong></td>
                                <td>Tidak ada pelayanan diluar prosedur/kecurangan pelayanan pada unit layanan ini</td>
                                <td><span class="badge badge-warning">{{ $survey->i2_tidak_curang ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSpakScoreLabel($survey->i2_tidak_curang) }}</td>
                            </tr>
                            <tr>
                                <td><strong>I3</strong></td>
                                <td>Tidak ada penerimaan imbalan/uang/barang/fasilitas diluar ketentuan yang berlaku pada unit layanan ini</td>
                                <td><span class="badge badge-warning">{{ $survey->i3_tidak_imbalan ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSpakScoreLabel($survey->i3_tidak_imbalan) }}</td>
                            </tr>
                            <tr>
                                <td><strong>I4</strong></td>
                                <td>Tidak ada percaloan/perantara tidak resmi pada unit layanan ini</td>
                                <td><span class="badge badge-warning">{{ $survey->i4_tidak_percaloan ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSpakScoreLabel($survey->i4_tidak_percaloan) }}</td>
                            </tr>
                            <tr>
                                <td><strong>I5</strong></td>
                                <td>Tidak ada pungutan liar (pungli) pada unit layanan ini</td>
                                <td><span class="badge badge-warning">{{ $survey->i5_tidak_pungli ?? '-' }}</span></td>
                                <td>{{ \App\Models\SurveySkmSpak::getSpakScoreLabel($survey->i5_tidak_pungli) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alert alert-info mt-3">
                        <strong>Rata-rata SPAK:</strong> {{ $statistics['spak_average'] ?? 'N/A' }}/4.0
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kritik & Saran -->
    @if($survey->kritik_saran)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">
                        <i class="fas fa-comments mr-2"></i> Kritik & Saran
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ nl2br(e($survey->kritik_saran)) }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Metadata -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i> Informasi Teknis
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>IP Address:</strong>
                            <p class="text-muted">{{ $survey->ip_address ?? 'Tidak tercatat' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>User Agent:</strong>
                            <p class="text-muted text-truncate" title="{{ $survey->user_agent }}">{{ $survey->user_agent ?? 'Tidak tercatat' }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Dibuat:</strong>
                            <p class="text-muted">{{ $survey->created_at->locale('id')->format('d F Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Diperbarui:</strong>
                            <p class="text-muted">{{ $survey->updated_at->locale('id')->format('d F Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash mr-2"></i> Hapus Survey
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus survey ini?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.surveys-skm-spak.destroy', $survey->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
