@extends("layouts.app")
@section("title", "Informasi Berkala - PPID")
@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url("/") }}">Beranda</a></li>
    <li class="breadcrumb-item active">Informasi Berkala</li>
@endsection
@php
$colors = ['A'=>'primary','B'=>'success','C'=>'info','D'=>'warning','E'=>'secondary'];
@endphp
@section("content")
<div class="container my-4">
    <div class="mb-4">
        <h4 class="fw-bold text-success"><i class="bi bi-file-earmark-text me-2"></i>Informasi Berkala</h4>
        <p class="text-muted mb-0">Informasi yang wajib tersedia setiap saat</p>
    </div>

    @if($items->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="60" class="text-center">No</th>
                    <th>Daftar Informasi Publik</th>
                </tr>
            </thead>
            <tbody>
                @php $colors = ['A'=>'primary','B'=>'success','C'=>'info','D'=>'warning','E'=>'secondary']; @endphp
                @foreach($itemsByKategori as $kode => $items)
                    <tr class="table-{{ $colors[$kode] ?? 'secondary' }}">
                        <td class="text-center fw-bold">{{ $kode }}</td>
                        <td class="fw-bold">{{ preg_replace('/^[A-Z]\.\s*/', '', $kategoriOptions[$kode] ?? '') }}</td>
                    </tr>
                    @foreach($items as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td><a href="{{ $item->link }}" target="_blank">{{ $item->judul }}</a></td>
                    </tr>
                    @endforeach
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1"></i>
            <p class="mt-2">Belum ada informasi berkala</p>
        </div>
    @endif
</div>
@endsection