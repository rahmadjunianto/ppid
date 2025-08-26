@extends('admin.layouts.app')

@section('title', 'Detail Survey')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Survey</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.surveys.index') }}">Data Survey</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="row">
                <!-- Biodata Responden -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user"></i> Biodata Responden</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Nama</th>
                                    <td>{{ $survey->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Umur</th>
                                    <td>{{ $survey->umur }} tahun</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $survey->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td>{{ $survey->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Pendidikan</th>
                                    <td>{{ $survey->pendidikan }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>{{ $survey->pekerjaan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Submit</th>
                                    <td>{{ $survey->created_at->format('d F Y H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <th>IP Address</th>
                                    <td>{{ $survey->ip_address ?: 'Tidak tersedia' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hasil Survey -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-star"></i> Hasil Survey</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $questions = [
                                    'kemudahan_akses_informasi' => 'Kemudahan akses informasi PPID pada website',
                                    'kualitas_informasi' => 'Ketersediaan/kualitas informasi terkait layanan informasi PPID',
                                    'kemudahan_permintaan' => 'Kemudahan dalam mengajukan permintaan informasi',
                                    'ketepatan_waktu_jawab' => 'Ketepatan waktu dalam menjawab permintaan informasi',
                                    'kelengkapan_informasi' => 'Kelengkapan/kesesuaian informasi yang diberikan',
                                    'ketepatan_tanggap' => 'Ketepatan waktu dalam menjawab/menanggapi permintaan',
                                    'pelayanan_petugas' => 'Pelayanan petugas dalam melayani permintaan informasi'
                                ];
                                
                                $ratings = [
                                    1 => ['label' => 'Tidak Baik', 'color' => 'danger'],
                                    2 => ['label' => 'Kurang Baik', 'color' => 'warning'],
                                    3 => ['label' => 'Baik', 'color' => 'info'],
                                    4 => ['label' => 'Sangat Baik', 'color' => 'success']
                                ];
                            @endphp

                            @foreach($questions as $key => $question)
                            <div class="mb-3">
                                <strong>{{ $loop->iteration }}. {{ $question }}</strong>
                                <br>
                                @php
                                    $score = $survey->$key;
                                    $rating = $ratings[$score];
                                @endphp
                                <span class="badge badge-{{ $rating['color'] }} badge-lg">
                                    {{ $score }}/4 - {{ $rating['label'] }}
                                </span>
                            </div>
                            @endforeach

                            <hr>
                            
                            <!-- Average Rating -->
                            <div class="text-center">
                                <h5>Rata-rata Rating</h5>
                                @php
                                    $avgRating = $survey->getAverageRating();
                                @endphp
                                <h2 class="text-{{ $avgRating >= 3 ? 'success' : ($avgRating >= 2 ? 'warning' : 'danger') }}">
                                    {{ number_format($avgRating, 1) }}/4.0
                                </h2>
                                <p class="text-muted">
                                    ({{ round(($avgRating / 4) * 100) }}% tingkat kepuasan)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saran dan Masukan -->
            @if($survey->saran_masukan)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-comments"></i> Saran dan Masukan</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-quote-left"></i>
                                {{ $survey->saran_masukan }}
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i> Hapus Data Survey
                            </button>
                            
                            <form id="delete-form" action="{{ route('admin.surveys.destroy', $survey) }}" 
                                  method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
.badge-lg {
    font-size: 0.9em;
    padding: 0.5em 0.8em;
}

.card-title i {
    margin-right: 8px;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Hapus Data Survey?',
        text: "Data survey dari {{ $survey->nama }} akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form').submit();
        }
    });
}
</script>
@endpush
@endsection
