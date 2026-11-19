@php
    // $column   : App\Models\DynamicListColumn
    // $name      : nama field HTML (contoh: items[0][nama] atau item[nama])
    // $oldPath   : path dot-notation untuk old() (contoh: items.0.nama)
    // $value     : nilai saat ini (untuk mode edit)
    // $internalLinks : daftar opsi link internal
    // $item      : item yang sedang diedit (boleh null)
    $isFile = $column->isFileType();
    $isMulti = $column->is_multiple;
    $isAction = $column->isAction();

    $current = old($oldPath, $value);
    $fieldName = $isMulti && ! $isFile ? $name.'[]' : $name;
    $fileName = $isFile ? $name.'[]' : $name;

    $existingFiles = $item ? $item->files->where('dynamic_list_column_id', $column->id) : collect();
@endphp

<div class="form-group mb-3">
    <label class="mb-1">
        {{ $column->label }}
        @if($column->is_required)
            <span class="text-danger">*</span>
        @endif
        <span class="badge bg-secondary ms-1">{{ $column->typeLabel() }}</span>
        @if($isAction)
            <span class="badge bg-info ms-1">{{ $column->actionTypeLabel() }}</span>
        @endif
    </label>

    @if($isFile)
        @if($existingFiles->isNotEmpty())
            <div class="mb-2">
                @foreach($existingFiles as $existing)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remove_files[{{ $column->key }}][]"
                               value="{{ $existing->id }}" id="rm-{{ $existing->id }}">
                        <label class="form-check-label small" for="rm-{{ $existing->id }}">
                            Hapus file: {{ $existing->original_name }} ({{ $existing->human_size }})
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <input type="file" class="form-control form-control-sm" name="{{ $fileName }}"
               @if($isMulti || $isAction) multiple @endif>
        <small class="form-text text-muted">
            {{ $existingFiles->isNotEmpty() ? 'File lama tetap disimpan kecuali dicentang untuk dihapus. ' : '' }}
            Format: pdf, doc, docx, xls, xlsx, png, jpg, jpeg (maks 10 MB).
        </small>
    @elseif($isMulti)
        @php $multiValues = is_array($current) ? $current : ($current !== null && $current !== '' ? [$current] : []); @endphp
        <div class="multi-values" data-multi-container>
            @foreach($multiValues as $multiValue)
                <div class="input-group mb-1 multi-value-group">
                    @include('admin.lists.items._multi_control', [
                        'column' => $column,
                        'fieldName' => $fieldName,
                        'multiValue' => $multiValue,
                    ])
                    <button type="button" class="btn btn-outline-danger btn-sm multi-remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary multi-add">
            <i class="fas fa-plus me-1"></i> Tambah Nilai
        </button>
    @elseif($isAction && $column->action_type === 'internal')
        <input type="text" list="internal-links-{{ $column->id }}" class="form-control form-control-sm"
               name="{{ $name }}" value="{{ $current }}" placeholder="/halaman-tujuan">
        <small class="form-text text-muted">Pilih halaman yang sudah dipublikasikan atau tulis path diawali "/".</small>
    @elseif($isAction && $column->action_type === 'external')
        <input type="url" class="form-control form-control-sm" name="{{ $name }}" value="{{ $current }}"
               placeholder="https://contoh.go.id">
    @elseif($column->type === 'select')
        <select class="form-select form-select-sm" name="{{ $name }}">
            <option value="">-- Pilih --</option>
            @foreach($column->optionPairs() as $opt)
                <option value="{{ $opt['value'] }}" {{ (string) $opt['value'] === (string) $current ? 'selected' : '' }}>
                    {{ $opt['label'] ?? $opt['value'] }}
                </option>
            @endforeach
        </select>
    @elseif($column->type === 'textarea')
        <textarea class="form-control form-control-sm" name="{{ $name }}" rows="3">{{ $current }}</textarea>
    @elseif($column->type === 'boolean')
        <select class="form-select form-select-sm" name="{{ $name }}">
            <option value="">-- Pilih --</option>
            <option value="1" {{ (string) $current === '1' ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ (string) $current === '0' ? 'selected' : '' }}>Tidak</option>
        </select>
    @elseif($column->type === 'number')
        <input type="number" step="any" class="form-control form-control-sm" name="{{ $name }}" value="{{ $current }}">
    @elseif($column->type === 'date')
        <input type="date" class="form-control form-control-sm" name="{{ $name }}" value="{{ $current }}">
    @else
        <input type="text" class="form-control form-control-sm" name="{{ $name }}" value="{{ $current }}">
    @endif

    @error($oldPath)
        <span class="invalid-feedback d-block">{{ $message }}</span>
    @enderror
</div>
