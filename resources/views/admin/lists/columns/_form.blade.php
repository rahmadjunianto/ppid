@php
    $isEdit = isset($column) && $column;
    $selectedType = old('type', $isEdit ? $column->type : 'text');
    $selectedAction = old('action_type', $isEdit ? ($column->action_type ?? 'internal') : 'internal');
    $optionsText = old('options_text', $isEdit ? collect($column->optionPairs())
        ->map(fn ($opt) => ($opt['label'] ?? $opt['value']).' | '.$opt['value'])
        ->implode("\n") : '');
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="label">Label Kolom <span class="text-danger">*</span></label>
            <input type="text" name="label" id="label" class="form-control @error('label') is-invalid @enderror"
                   value="{{ old('label', $isEdit ? $column->label : '') }}" required maxlength="255"
                   placeholder="Contoh: Nama Dokumen">
            @error('label')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="key">Key Data</label>
            <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror"
                   value="{{ old('key', $isEdit ? $column->key : '') }}" maxlength="100"
                   placeholder="Kosongkan untuk dibuat otomatis dari label">
            <small class="form-text text-muted">
                Key dipakai sebagai penampung nilai. Mengubah key akan memindahkan nilai pada seluruh baris data.
            </small>
            @error('key')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="type">Tipe Kolom <span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                @foreach(\App\Models\DynamicListColumn::TYPES as $value => $text)
                    <option value="{{ $value }}" {{ $selectedType === $value ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            </select>
            @error('type')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-6" id="action-type-wrapper" style="display: {{ $selectedType === 'action' ? 'block' : 'none' }};">
        <div class="form-group">
            <label for="action_type">Jenis Aksi <span class="text-danger">*</span></label>
            <select name="action_type" id="action_type" class="form-control @error('action_type') is-invalid @enderror">
                @foreach(\App\Models\DynamicListColumn::ACTION_TYPES as $value => $text)
                    <option value="{{ $value }}" {{ $selectedAction === $value ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Kolom aksi wajib bertipe link internal, link eksternal, atau upload file.</small>
            @error('action_type')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-12" id="options-wrapper" style="display: {{ $selectedType === 'select' ? 'block' : 'none' }};">
        <div class="form-group">
            <label for="options_text">Pilihan Dropdown</label>
            <textarea name="options_text" id="options_text" rows="5" class="form-control @error('options_text') is-invalid @enderror"
                      placeholder="Label | value&#10;Label 2 | value2">{{ old('options_text', $optionsText) }}</textarea>
            <small class="form-text text-muted">Satu pilihan per baris dengan format "Label | value". Tanpa "|" maka label = value.</small>
            @error('options_text')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="sort_order">Urutan</label>
            <input type="number" name="sort_order" id="sort_order" min="0"
                   class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $isEdit ? $column->sort_order : 0) }}">
            @error('sort_order')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-check mt-4">
            <input type="hidden" name="is_multiple" value="0">
            <input type="checkbox" class="form-check-input" id="is_multiple" name="is_multiple" value="1"
                   {{ old('is_multiple', $isEdit && $column->is_multiple ? '1' : '0') == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="is_multiple">Boleh banyak nilai</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-check mt-4">
            <input type="hidden" name="is_required" value="0">
            <input type="checkbox" class="form-check-input" id="is_required" name="is_required" value="1"
                   {{ old('is_required', $isEdit && $column->is_required ? '1' : '0') == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="is_required">Wajib diisi</label>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        var typeSelect = document.getElementById('type');
        var actionWrapper = document.getElementById('action-type-wrapper');
        var optionsWrapper = document.getElementById('options-wrapper');

        function toggleSections() {
            var type = typeSelect.value;
            actionWrapper.style.display = type === 'action' ? 'block' : 'none';
            optionsWrapper.style.display = type === 'select' ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleSections);
        toggleSections();
    })();
</script>
@endpush
