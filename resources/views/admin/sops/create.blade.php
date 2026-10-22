@extends('admin.layouts.app')
@section('title', 'Tambah SOP Baru')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.sops.index') }}">Kelola SOP</a></li>
<li class="breadcrumb-item active">Tambah Baru</li>
@endsection
@section('content')
<div class="row">
<div class="col-12">
<div class="card card-success">
<div class="card-header">
<h3 class="card-title"><i class="fas fa-plus mr-2"></i>Tambah Dokumen SOP Baru</h3>
<div class="card-tools">
<a href="{{ route('admin.sops.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
</div>
<form action="{{ route('admin.sops.store') }}" method="POST" enctype="multipart/form-data" id="form-sop-multiple">
@csrf
<div class="card-body">
@if($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

@if(session('failed_items'))
<div class="alert alert-warning">
    <ul class="mb-0">
        @foreach(session('failed_items') as $failed)
            <li>{{ $failed }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    Anda dapat menambah beberapa dokumen SOP sekaligus. Klik <strong>"Tambah Baris"</strong> untuk menambah baris form baru,
    isi data setiap baris, lalu tekan <strong>Simpan Semua</strong>.
</div>
<div id="sop-rows">
@for ($i = 0; $i < $jumlahRows; $i++)
@include('admin.sops._row', ['idx' => $i, 'grupOptions' => $grupOptions])
@endfor
</div>

<div class="mb-3">
<button type="button" class="btn btn-outline-success" id="btn-add-row">
<i class="fas fa-plus-circle"></i> Tambah Baris
</button>
<button type="button" class="btn btn-outline-secondary ml-2" id="btn-add-5-rows">
<i class="fas fa-plus-square"></i> Tambah 5 Baris
</button>
<button type="button" class="btn btn-outline-danger ml-2" id="btn-clear-rows">
<i class="fas fa-eraser"></i> Reset Baris
</button>
<span class="text-muted ml-2" id="row-counter"></span>
</div>
</div>
<div class="card-footer">
<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Semua</button>
<button type="reset" class="btn btn-default"><i class="fas fa-undo"></i> Reset Form</button>
</div>
</form>
</div>
</div>
</div>

{{-- Template baris kosong untuk ditambahkan via JavaScript --}}
<template id="sop-row-template">
@include('admin.sops._row', ['idx' => '__INDEX__', 'grupOptions' => $grupOptions])
</template>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var rowsContainer = document.getElementById('sop-rows');
    var btnAdd        = document.getElementById('btn-add-row');
    var btnAdd5       = document.getElementById('btn-add-5-rows');
    var btnClear      = document.getElementById('btn-clear-rows');
    var counter       = document.getElementById('row-counter');
    var rowTemplate   = document.getElementById('sop-row-template');

    /**
     * Hitung jumlah baris form saat ini.
     */
    function rowCount() {
        return rowsContainer.querySelectorAll('.sop-item-row').length;
    }

    /**
     * Normalisasi indeks baris agar name="items[N][...]" selalu berurutan.
     */
    function reindex() {
        var rows = rowsContainer.querySelectorAll('.sop-item-row');

        Array.prototype.forEach.call(rows, function (row, index) {
            row.setAttribute('data-row-index', index);

            row.querySelectorAll('input, select, textarea').forEach(function (field) {
                if (!field.name) return;
                field.name = field.name.replace(/items\[(\d+|__INDEX__)\]/, 'items[' + index + ']');
            });

            var numberBadge = row.querySelector('.sop-item-number');
            if (numberBadge) numberBadge.textContent = index + 1;
        });

        counter.textContent = '(' + rows.length + ' baris form)';
    }

    /**
     * Tampilkan nama file yang dipilih.
     */
    function bindFileName(row) {
        var input = row.querySelector('input[type="file"]');
        var label = row.querySelector('.sop-file-name');

        if (!input || !label) return;

        input.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                label.textContent = 'File dipilih: ' + this.files[0].name;
            } else {
                label.textContent = 'Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal: 10MB';
            }
        });
    }

    /**
     * Tambah satu baris form baru.
     */
    function addRow() {
        var wrapper = document.createElement('div');
        wrapper.innerHTML = rowTemplate.innerHTML;

        var newRow = wrapper.firstElementChild;
        if (!newRow) return;

        rowsContainer.appendChild(newRow);
        reindex();
        bindFileName(newRow);
    }

    // Tombol tambah baris
    btnAdd.addEventListener('click', addRow);

    btnAdd5.addEventListener('click', function () {
        for (var i = 0; i < 5; i++) {
            addRow();
        }
    });

    // Tombol reset baris (sisakan minimal 1 baris)
    btnClear.addEventListener('click', function () {
        rowsContainer.innerHTML = '';
        addRow();
    });

    // Hapus baris
    rowsContainer.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn-remove-row');
        if (!btn) return;

        var row = btn.closest('.sop-item-row');
        if (!row) return;

        // Sisakan minimal satu baris
        if (rowCount() <= 1) {
            row.querySelectorAll('input, select, textarea').forEach(function (field) {
                if (field.type === 'file' || field.type === 'checkbox' || field.type === 'radio') {
                    field.value = '';
                } else if (field.tagName === 'SELECT') {
                    field.selectedIndex = 0;
                } else {
                    field.value = '';
                }
            });
            return;
        }

        row.remove();
        reindex();
    });

    // Validasi sebelum submit: baris yang sepenuhnya kosong diabaikan,
    // baris yang terisi sebagian harus lengkap (nama dokumen + file + grup).
    document.getElementById('form-sop-multiple').addEventListener('submit', function (e) {
        var invalid = false;

        rowsContainer.querySelectorAll('.sop-item-row').forEach(function (row) {
            var name    = row.querySelector('input[name$="[nama_dokumen]"]');
            var file    = row.querySelector('input[type="file"]');
            var grup    = row.querySelector('select[name$="[grup]"]');
            var hasName = name && name.value.trim() !== '';
            var hasFile = file && file.files && file.files.length > 0;

            // Baris kosong -> dilewati (diabaikan oleh server)
            if (!hasName && !hasFile) {
                return;
            }

            if (!hasName) {
                name.classList.add('is-invalid');
                invalid = true;
            }

            if (!hasFile) {
                file.classList.add('is-invalid');
                invalid = true;
            }

            if (grup && !grup.value) {
                grup.classList.add('is-invalid');
                invalid = true;
            }
        });

        if (invalid) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Lengkapi Form!',
                text: 'Setiap baris yang diisi harus lengkap: nama dokumen, grup, dan file SOP.',
                confirmButtonColor: '#1e5631'
            });
        }
    });

    // Inisialisasi
    rowsContainer.querySelectorAll('.sop-item-row').forEach(bindFileName);
    reindex();
})();
</script>
@endpush