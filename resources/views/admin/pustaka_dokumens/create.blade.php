@extends('admin.layouts.app')
@section('title', 'Tambah Dokumen')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Tambah Dokumen</h5>
    </div>
    <form action="{{ route('admin.pustaka-dokumens.store') }}" method="POST" enctype="multipart/form-data" id="form-pustaka-multiple">
        @csrf
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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
                Anda dapat menambah beberapa dokumen sekaligus. Klik <strong>"Tambah Baris"</strong> untuk menambah baris form baru,
                isi data setiap baris, lalu tekan <strong>Simpan Semua</strong>. Baris yang kosong akan diabaikan otomatis.
            </div>

            <div id="pustaka-rows">
                @for ($i = 0; $i < $jumlahRows; $i++)
                    @include('admin.pustaka_dokumens._row', ['idx' => $i, 'grupDokumens' => $grupDokumens])
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
            <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); border: none;">
                <i class="fas fa-save"></i> Simpan Semua
            </button>
            <a href="{{ route('admin.pustaka-dokumens.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

{{-- Template baris kosong untuk ditambahkan via JavaScript --}}
<template id="pustaka-row-template">
    @include('admin.pustaka_dokumens._row', ['idx' => '__INDEX__', 'grupDokumens' => $grupDokumens])
</template>
@endsection

@push('scripts')
<script>
(function () {
    var rowsContainer = document.getElementById('pustaka-rows');
    var template      = document.getElementById('pustaka-row-template');
    var counter       = document.getElementById('row-counter');

    function rows() {
        return Array.prototype.slice.call(rowsContainer.querySelectorAll('.pustaka-item-row'));
    }

    function reindex() {
        rows().forEach(function (row, index) {
            row.setAttribute('data-row-index', index);
            var number = row.querySelector('.pustaka-item-number');
            if (number) { number.textContent = index + 1; }
            row.querySelectorAll('input, select, textarea').forEach(function (field) {
                if (!field.name) { return; }
                field.name = field.name.replace(/items\[(\d+|__INDEX__)\]/, 'items[' + index + ']');
            });
        });
        if (counter) {
            counter.textContent = '(' + rows().length + ' baris form)';
        }
    }

    function toggleLinkType(row) {
        if (!row) { return; }
        var checked = row.querySelector('input.pustaka-link-type:checked');
        var type    = checked ? checked.value : 'file';
        var fileOpt = row.querySelector('.pustaka-file-option');
        var linkOpt = row.querySelector('.pustaka-link-option');
        var fileSec = row.querySelector('.pustaka-file-section');
        var linkSec = row.querySelector('.pustaka-link-section');

        if (fileOpt) {
            fileOpt.classList.toggle('border-success', type === 'file');
            fileOpt.classList.toggle('bg-success', type === 'file');
            fileOpt.classList.toggle('bg-opacity-10', type === 'file');
        }
        if (linkOpt) {
            linkOpt.classList.toggle('border-success', type === 'link');
            linkOpt.classList.toggle('bg-success', type === 'link');
            linkOpt.classList.toggle('bg-opacity-10', type === 'link');
        }
        if (fileSec) { fileSec.classList.toggle('d-none', type !== 'file'); }
        if (linkSec) { linkSec.classList.toggle('d-none', type !== 'link'); }
    }

    function addRow() {
        var html = template.innerHTML.replace(/__INDEX__/g, '0');
        var wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        var row = wrapper.querySelector('.pustaka-item-row');
        rowsContainer.appendChild(row);
        reindex();
        toggleLinkType(row);
        return row;
    }

    function removeRow(row) {
        if (rows().length <= 1) {
            window.alert('Minimal harus ada satu baris form.');
            return;
        }
        row.remove();
        reindex();
    }

    function isRowEmpty(row) {
        var name = row.querySelector('[name$="[nama_dokumen]"]');
        var link = row.querySelector('[name$="[link_url]"]');
        var file = row.querySelector('input[type="file"]');
        return !(name && name.value.trim() !== '')
            && !(link && link.value.trim() !== '')
            && !(file && file.files.length > 0);
    }

    document.getElementById('btn-add-row').addEventListener('click', function () { addRow(); });

    document.getElementById('btn-add-5-rows').addEventListener('click', function () {
        for (var i = 0; i < 5; i++) { addRow(); }
    });

    document.getElementById('btn-clear-rows').addEventListener('click', function () {
        rows().forEach(function (row, index) { if (index > 0) { row.remove(); } });
        reindex();
    });

    rowsContainer.addEventListener('click', function (e) {
        var btn = e.target.closest ? e.target.closest('.btn-remove-row') : null;
        if (btn) {
            e.preventDefault();
            removeRow(btn.closest('.pustaka-item-row'));
        }
    });

    rowsContainer.addEventListener('change', function (e) {
        if (e.target.classList.contains('pustaka-link-type')) {
            toggleLinkType(e.target.closest('.pustaka-item-row'));
        }
        if (e.target.type === 'file') {
            var section = e.target.closest('.pustaka-file-section');
            var label = section ? section.querySelector('.pustaka-file-name') : null;
            if (label) {
                label.textContent = e.target.files.length
                    ? e.target.files[0].name
                    : 'Format: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG (Max: 10MB)';
            }
        }
    });

    document.getElementById('form-pustaka-multiple').addEventListener('submit', function (e) {
        var errors = [];
        rows().forEach(function (row, index) {
            if (isRowEmpty(row)) { return; }
            var name = row.querySelector('[name$="[nama_dokumen]"]');
            var grup = row.querySelector('[name$="[grup_dokumen_id]"]');
            var type = row.querySelector('input.pustaka-link-type:checked');
            var file = row.querySelector('input[type="file"]');
            var link = row.querySelector('[name$="[link_url]"]');

            if (!name || name.value.trim() === '') {
                errors.push('Baris ' + (index + 1) + ': Nama Dokumen wajib diisi.');
            }
            if (!grup || grup.value === '') {
                errors.push('Baris ' + (index + 1) + ': Kategori Dokumen wajib dipilih.');
            }
            if (type && type.value === 'file' && (!file || file.files.length === 0)) {
                errors.push('Baris ' + (index + 1) + ': File wajib dipilih atau pilih tipe "Input Link".');
            }
            if (type && type.value === 'link' && (!link || link.value.trim() === '')) {
                errors.push('Baris ' + (index + 1) + ': Link wajib diisi atau pilih tipe "Upload File".');
            }
        });

        if (errors.length > 0) {
            e.preventDefault();
            window.alert(errors.join('\n'));
        }
    });

    reindex();
    rows().forEach(function (row) { toggleLinkType(row); });
})();
</script>
@endpush


