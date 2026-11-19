@php
    $isEdit = isset($dynamicList) && $dynamicList;
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="title">Judul Daftar <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $isEdit ? $dynamicList->title : '') }}" required maxlength="255"
                   placeholder="Contoh: Daftar Dokumeninerja">
            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="slug">Slug URL</label>
            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                   value="{{ old('slug', $isEdit ? $dynamicList->slug : '') }}" maxlength="255"
                   placeholder="otomatis dari judul">
            <small class="form-text text-muted">URL publik: <code>/lists/{{ old('slug', $isEdit ? $dynamicList->slug : 'slug-daftar') }}</code></small>
            @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Penjelasan singkat mengenai daftar ini">{{ old('description', $isEdit ? $dynamicList->description : '') }}</textarea>
            @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                @php $currentStatus = old('status', $isEdit ? $dynamicList->status : 'draft'); @endphp
                <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ $currentStatus === 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ $currentStatus === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="sort_order">Urutan</label>
            <input type="number" name="sort_order" id="sort_order" min="0"
                   class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $isEdit ? $dynamicList->sort_order : 0) }}">
            @error('sort_order')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-check mt-4">
            <input type="hidden" name="show_title" value="0">
            <input type="checkbox" class="form-check-input" id="show_title" name="show_title" value="1"
                   {{ old('show_title', $isEdit ? $dynamicList->show_title : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="show_title">Tampilkan judul pada halaman publik</label>
        </div>
    </div>
</div>
