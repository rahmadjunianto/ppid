@extends('admin.layouts.app')

@section('title', 'Tambah Data')
@section('page-title', 'Tambah Data')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.index') }}">Daftar Dinamis</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.lists.items.index', $dynamicList) }}">{{ $dynamicList->title }}</a></li>
    <li class="breadcrumb-item active">Tambah Data</li>
@endsection

@section('content')
<form action="{{ route('admin.lists.items.store', $dynamicList) }}" method="POST" enctype="multipart/form-data" id="items-form">
    @csrf

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header" style="background: linear-gradient(135deg, #1e5631 0%, #2d8f47 100%); color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Tambah Data: {{ $dynamicList->title }}</h5>
                <span class="badge badge-light">Mode banyak baris</span>
            </div>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-1"></i>
                Formulir dapat diisi lebih dari satu baris sekaligus. Baris yang dikosongkan akan otomatis dilewati.
                <span class="d-block mt-1 small">Jumlah baris: <strong id="row-count">{{ $jumlahRows }}</strong></span>
            </div>

            @for($row = 0; $row < $jumlahRows; $row++)
                <div class="card mb-3 item-row" data-row-index="{{ $row }}">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background: #f1f3f5;">
                        <strong>Baris {{ $row + 1 }}</strong>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                            <i class="fas fa-times me-1"></i> Hapus Baris
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($columns as $column)
                                <div class="col-md-6">
                                    @include('admin.lists.items._field', [
                                        'column' => $column,
                                        'name' => 'items['.$row.']['.$column->key.']',
                                        'oldPath' => 'items.'.$row.'.'.$column->key,
                                        'value' => null,
                                        'internalLinks' => $internalLinks,
                                        'item' => null,
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Simpan Semua Baris
            </button>
            <button type="button" class="btn btn-outline-success" id="add-row">
                <i class="fas fa-plus me-1"></i> Tambah Baris
            </button>
            <a href="{{ route('admin.lists.items.index', $dynamicList) }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> Batal
            </a>
        </div>
    </div>
</form>

@foreach($columns as $column)
    @if($column->isAction() && $column->action_type === 'internal')
        <datalist id="internal-links-{{ $column->id }}">
            @foreach($internalLinks as $link)
                <option value="{{ $link['value'] }}">{{ $link['label'] }}</option>
            @endforeach
        </datalist>
    @endif
@endforeach

@endsection

@push('scripts')
<script>
    (function () {
        var form = document.getElementById('items-form');
        var rowCounter = {{ $jumlahRows }};

        function updateCount() {
            var rows = form.querySelectorAll('.item-row');
            document.getElementById('row-count').textContent = rows.length;
        }

        // Template baris kosong (di-generate ulang dari baris terakhir).
        function buildRow(index) {
            var template = form.querySelector('.item-row[data-row-index="' + (index - 1) + '"]');
            if (!template) {
                return null;
            }

            var clone = template.cloneNode(true);
            clone.setAttribute('data-row-index', index);

            clone.querySelectorAll('input, select, textarea').forEach(function (el) {
                el.value = '';
                if (el.type === 'checkbox' || el.type === 'radio') {
                    el.checked = false;
                }
                // Ganti indeks pada nama field.
                if (el.name) {
                    el.name = el.name.replace(/\[\d+\]\[/, '[' + index + '][');
                }
                // Hapus id duplikat.
                if (el.id) {
                    el.removeAttribute('id');
                }
            });

            clone.querySelectorAll('.multi-values').forEach(function (container) {
                var groups = container.querySelectorAll('.multi-value-group');
                if (groups.length > 1) {
                    groups.forEach(function (group, idx) {
                        if (idx > 0) {
                            group.remove();
                        }
                    });
                }
            });

            clone.querySelectorAll('.invalid-feedback').forEach(function (fb) {
                fb.remove();
            });

            var header = clone.querySelector('.card-header strong');
            if (header) {
                header.textContent = 'Baris ' + (index + 1);
            }

            return clone;
        }

        document.getElementById('add-row').addEventListener('click', function () {
            var newRow = buildRow(rowCounter);
            if (!newRow) {
                return;
            }
            newRow.querySelectorAll('input[type="file"]').forEach(function (el) {
                el.value = '';
            });
            form.querySelector('#items-form').appendChild(newRow);
            rowCounter++;
            updateCount();
        });

        form.addEventListener('click', function (e) {
            if (e.target.closest('.remove-row')) {
                var rows = form.querySelectorAll('.item-row');
                if (rows.length > 1) {
                    e.target.closest('.item-row').remove();
                    updateCount();
                }
            }

            if (e.target.closest('.multi-remove')) {
                e.target.closest('.multi-value-group').remove();
            }

            if (e.target.closest('.multi-add')) {
                var wrapper = e.target.closest('.form-group');
                var container = wrapper.querySelector('[data-multi-container]');
                var lastGroup = container.querySelector('.multi-value-group:last-child');
                if (!lastGroup) {
                    return;
                }
                var clone = lastGroup.cloneNode(true);
                clone.querySelectorAll('input, select, textarea').forEach(function (el) {
                    el.value = '';
                    el.removeAttribute('id');
                });
                container.appendChild(clone);
            }
        });

        updateCount();
    })();
</script>
@endpush
