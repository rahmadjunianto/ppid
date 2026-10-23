@extends('admin.layouts.app')

@section('title', 'Tambah Regulasi')
@section('page-title', 'Tambah Regulasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.regulasi.index') }}">Kelola Regulasi</a></li>
    <li class="breadcrumb-item active">Tambah Regulasi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus mr-2"></i>Tambah Regulasi &amp; Peraturan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.regulasi.store') }}" method="POST" enctype="multipart/form-data" id="form-regulasi-multiple">
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
                            Anda dapat menambah beberapa regulasi sekaligus. Klik <strong>"Tambah Baris"</strong> untuk menambah baris form baru,
                            isi data setiap baris, lalu tekan <strong>Simpan Semua</strong>. Baris yang kosong akan diabaikan otomatis.
                        </div>

                        <div id="regulasi-rows">
                            @for ($i = 0; $i < $jumlahRows; $i++)
                                @include('admin.regulasi._row', ['idx' => $i, 'tingkatOptions' => $tingkatOptions])
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
                        <a href="{{ route('admin.regulasi.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    </div>
                </form>

                {{-- Template baris kosong untuk ditambahkan via JavaScript --}}
                <template id="regulasi-row-template">
                    @include('admin.regulasi._row', ['idx' => '__INDEX__', 'tingkatOptions' => $tingkatOptions])
                </template>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var rowsContainer = document.getElementById('regulasi-rows');
    var rowTemplate   = document.getElementById('regulasi-row-template');
    var counter       = document.getElementById('row-counter');

    if (!rowsContainer || !rowTemplate) {
        return;
    }

    /**
     * Ambil semua baris form yang aktif.
     */
    function rows() {
        return Array.prototype.slice.call(rowsContainer.querySelectorAll('.regulasi-item-row'));
    }

    /**
     * Normalisasi indeks baris agar name="items[N][...]" selalu berurutan.
     */
    function reindex() {
        rows().forEach(function (row, index) {
            row.setAttribute('data-row-index', index);

            row.querySelectorAll('input, select, textarea').forEach(function (field) {
                if (field.name) {
                    field.name = field.name.replace(/items\[[^\]]*\]/, 'items[' + index + ']');
                }
            });

            var number = row.querySelector('.regulasi-item-number');
            if (number) {
                number.textContent = index + 1;
            }
        });

        if (counter) {
            counter.textContent = rows().length + ' baris form';
        }
    }

    /**
     * Tampilkan hanya bagian yang sesuai dengan sumber dokumen terpilih.
     */
    function toggleLinkType(row) {
        var type = row.querySelector('input.regulasi-link-type:checked');
        var value = type ? type.value : 'file';

        var fileSection = row.querySelector('.regulasi-file-section');
        var linkSection = row.querySelector('.regulasi-link-section');

        if (fileSection) {
            fileSection.style.display = value === 'file' ? '' : 'none';
        }

        if (linkSection) {
            linkSection.style.display = value === 'link' ? '' : 'none';
        }
    }

    /**
     * Tambahkan satu baris form baru.
     */
    function addRow() {
        var wrapper = document.createElement('div');
        wrapper.innerHTML = rowTemplate.innerHTML;

        var newRow = wrapper.firstElementChild;
        if (!newRow) {
            return;
        }

        rowsContainer.appendChild(newRow);
        reindex();
        toggleLinkType(newRow);
    }

    /**
     * Hapus baris (sisakan minimal satu baris).
     */
    function removeRow(row) {
        if (!row) {
            return;
        }

        if (rows().length <= 1) {
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
    }

    /**
     * Baris dianggap kosong bila nama, file, maupun link tidak diisi.
     */
    function isRowEmpty(row) {
        var name = row.querySelector('[name$="[nama_regulasi]"]');
        var link = row.querySelector('[name$="[link_url]"]');
        var file = row.querySelector('input[type="file"]');

        return !(name && name.value.trim() !== '')
            && !(link && link.value.trim() !== '')
            && !(file && file.files && file.files.length > 0);
    }

    document.getElementById('btn-add-row').addEventListener('click', function () {
        addRow();
    });

    document.getElementById('btn-add-5-rows').addEventListener('click', function () {
        for (var i = 0; i < 5; i++) {
            addRow();
        }
    });

    document.getElementById('btn-clear-rows').addEventListener('click', function () {
        var list = rows();
        for (var i = list.length - 1; i >= 0; i--) {
            if (i > 0) {
                list[i].remove();
            }
        }
        reindex();
    });

    rowsContainer.addEventListener('click', function (e) {
        var btn = e.target.closest ? e.target.closest('.btn-remove-row') : null;
        if (btn) {
            e.preventDefault();
            removeRow(btn.closest('.regulasi-item-row'));
        }
    });

    rowsContainer.addEventListener('change', function (e) {
        if (e.target.classList.contains('regulasi-link-type')) {
            toggleLinkType(e.target.closest('.regulasi-item-row'));
            return;
        }

        if (e.target.type === 'file') {
            var section = e.target.closest('.regulasi-file-section');
            var label = section ? section.querySelector('.regulasi-file-name') : null;
            if (label) {
                label.textContent = e.target.files.length
                    ? e.target.files[0].name
                    : 'Format: PDF, DOC, DOCX, XLS, XLSX (Maks: 10MB)';
            }
        }
    });

    document.getElementById('form-regulasi-multiple').addEventListener('submit', function (e) {
        var errors = [];

        rows().forEach(function (row, index) {
            if (isRowEmpty(row)) {
                return;
            }

            var name = row.querySelector('[name$="[nama_regulasi]"]');
            var tingkat = row.querySelector('[name$="[tingkat]"]');
            var status = row.querySelector('[name$="[status]"]');
            var type = row.querySelector('input.regulasi-link-type:checked');
            var file = row.querySelector('input[type="file"]');
            var link = row.querySelector('[name$="[link_url]"]');

            if (!name || name.value.trim() === '') {
                errors.push('Baris ' + (index + 1) + ': Nama Regulasi wajib diisi.');
            }

            if (!tingkat || tingkat.value === '') {
                errors.push('Baris ' + (index + 1) + ': Tingkat wajib dipilih.');
            }

            if (!status || status.value === '') {
                errors.push('Baris ' + (index + 1) + ': Status wajib dipilih.');
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
            Swal.fire({
                icon: 'warning',
                title: 'Lengkapi Form!',
                html: errors.join('<br>'),
                confirmButtonColor: '#1e5631'
            });
        }
    });

    // Inisialisasi
    reindex();
    rows().forEach(function (row) {
        toggleLinkType(row);
    });
})();
</script>
@endpush
