@extends('admin.layouts.app')

@section('title', 'Detail Pegawai')
@section('page-title', 'Detail Pegawai')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pegawai.index') }}">Data Pegawai</a></li>
    <li class="breadcrumb-item active">{{ $pegawai->nama }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        Detail Pegawai
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="150">Nama</th>
                            <td>{{ $pegawai->nama }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>{{ $pegawai->jabatan }}</td>
                        </tr>
                        @if($pegawai->golongan)
                        <tr>
                            <th>Golongan</th>
                            <td>{{ $pegawai->golongan }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Unit Kerja</th>
                            <td>{{ $pegawai->unit_kerja }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $pegawai->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diupdate</th>
                            <td>{{ $pegawai->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
                            <th>Urutan Tampil</th>
                            <td>{{ $pegawai->urutan }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $pegawai->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui</th>
                            <td>{{ $pegawai->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="card-footer">
                    <form action="{{ route('admin.pegawai.destroy', $pegawai) }}"
                          method="POST"
                          style="display: inline-block;"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus Pegawai
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
