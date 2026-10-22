<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrupDokumen;
use App\Models\PustakaDokumen;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class PustakaDokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = PustakaDokumen::with('grupDokumen')->latest();

        if ($request->filled('grup')) {
            $query->where('grup_dokumen_id', $request->grup);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $pustakaDokumens = $query->paginate(15)->withQueryString();
        $grupDokumens = GrupDokumen::active()->ordered()->get();

        return view('admin.pustaka_dokumens.index', compact('pustakaDokumens', 'grupDokumens'));
    }

    public function create(Request $request)
    {
        $grupDokumens = GrupDokumen::active()->ordered()->get();

        // Jumlah baris awal (untuk mode multiple form)
        $jumlahRows = (int) $request->query('jumlah', 1);

        // Jika sebelumnya gagal validasi, jumlah baris mengikuti data yang dikirim
        $oldItems = $request->session()->getOldInput('items');

        if (is_array($oldItems) && count($oldItems) > $jumlahRows) {
            $jumlahRows = count($oldItems);
        }

        $jumlahRows = max(1, min($jumlahRows, 50));

        return view('admin.pustaka_dokumens.create', compact('grupDokumens', 'jumlahRows'));
    }

    public function store(Request $request)
    {
        // Mode multiple form: field berupa array (items[0][nama_dokumen], items[0][file], dst.)
        if ($request->has('items')) {
            return $this->storeMultiple($request);
        }

        $validated = $request->validate([
            'grup_dokumen_id' => 'required|exists:grup_dokumens,id',
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'nomor' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'link_type' => 'required|in:file,link',
            'file' => 'nullable|required_if:link_type,file|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'link_url' => 'nullable|required_if:link_type,link|url',
            'created_by' => 'nullable|exists:users,id',
        ]);

        $validated['created_by'] = auth()->id();

        if ($request->link_type === 'file' && $request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($validated['nama_dokumen']) . '-' . time() . '.' . $extension;
            $path = $file->storeAs('pustaka-dokumen', $filename, 'public');
            $validated['file'] = $path;
            $validated['ukuran'] = $this->formatFileSize($file->getSize());
        }

        PustakaDokumen::create($validated);

        return redirect()->route('admin.pustaka-dokumens.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Simpan banyak dokumen (Daftar Informasi Publik) sekaligus dari satu form (multiple form).
     *
     * Field dikirim sebagai array: items[0][nama_dokumen], items[0][file], items[0][link_url], dst.
     */
    protected function storeMultiple(Request $request)
    {
        $items = $request->input('items', []);
        $files = $request->file('items', []);

        // Buang baris yang benar-benar kosong (tidak ada nama dokumen, file, maupun link).
        // Indeks asli dipertahankan agar pesan error cocok dengan baris form.
        $cleanItems = [];

        foreach ($items as $index => $item) {
            $hasName = trim((string) ($item['nama_dokumen'] ?? '')) !== '';
            $hasLink = trim((string) ($item['link_url'] ?? '')) !== '';
            $upload  = $files[$index]['file'] ?? null;
            $hasFile = $upload instanceof UploadedFile
                && $upload->getError() === UPLOAD_ERR_OK
                && $upload->getSize() > 0;

            if (! $hasName && ! $hasFile && ! $hasLink) {
                continue;
            }

            $item['file'] = $hasFile ? $upload : null;
            $cleanItems[$index] = $item;
        }

        // Tidak ada baris yang terisi sama sekali
        if (count($cleanItems) === 0) {
            return redirect()->route('admin.pustaka-dokumens.create')
                ->withErrors(['items' => 'Minimal satu baris dokumen harus diisi.'])
                ->withInput();
        }

        // Catatan: required_if wajib memakai path penuh (items.*.link_type) agar
        // berlaku di dalam array, bukan hanya di level atas.
        $rules = [
            'items'                   => 'required|array|min:1',
            'items.*.nama_dokumen'    => 'required|string|max:255',
            'items.*.grup_dokumen_id' => 'required|exists:grup_dokumens,id',
            'items.*.deskripsi'       => 'nullable|string|max:1000',
            'items.*.nomor'           => 'nullable|string|max:100',
            'items.*.tahun'           => 'nullable|integer|min:2000|max:2100',
            'items.*.link_type'       => 'required|in:file,link',
            'items.*.file'            => 'nullable|required_if:items.*.link_type,file|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'items.*.link_url'        => 'nullable|required_if:items.*.link_type,link|url',
        ];

        // Validasi manual (data sudah dibersihkan) -> error diarahkan ke baris form yang sesuai
        Validator::make(['items' => $cleanItems], $rules)->validate();

        $success = 0;
        $failed  = [];

        DB::transaction(function () use ($cleanItems, &$success, &$failed) {
            foreach ($cleanItems as $item) {
                try {
                    $data = [
                        'grup_dokumen_id' => $item['grup_dokumen_id'],
                        'nama_dokumen'    => $item['nama_dokumen'],
                        'deskripsi'       => $item['deskripsi'] ?? null,
                        'nomor'           => $item['nomor'] ?? null,
                        'tahun'           => $item['tahun'] ?? null,
                        'link_type'       => $item['link_type'],
                        'file'            => null,
                        'link_url'        => null,
                        'ukuran'          => null,
                        'created_by'      => auth()->id(),
                    ];

                    if ($item['link_type'] === 'file') {
                        $file      = $item['file'];
                        $extension = $file->getClientOriginalExtension();
                        $slug      = Str::slug($data['nama_dokumen']) ?: 'dokumen';
                        $filename  = $slug . '-' . time() . '-' . Str::random(4) . '.' . $extension;
                        $path      = $file->storeAs('pustaka-dokumen', $filename, 'public');

                        $data['file']   = $path;
                        $data['ukuran'] = $this->formatFileSize($file->getSize());
                    } else {
                        $data['link_url'] = $item['link_url'];
                    }

                    PustakaDokumen::create($data);

                    $success++;
                } catch (Throwable $e) {
                    $failed[] = ($item['nama_dokumen'] ?? 'Dokumen') . ' (' . $e->getMessage() . ')';
                }
            }
        });

        if ($success > 0) {
            $message = $success . ' dokumen berhasil ditambahkan.';

            if (count($failed) > 0) {
                $message .= ' ' . count($failed) . ' dokumen gagal disimpan.';
            }

            return redirect()->route('admin.pustaka-dokumens.index')
                ->with('success', $message)
                ->with('failed_items', $failed);
        }

        return redirect()->route('admin.pustaka-dokumens.index')
            ->with('error', 'Gagal menyimpan dokumen: ' . implode('; ', $failed));
    }

    public function edit(PustakaDokumen $pustakaDokumen)
    {
        $grupDokumens = GrupDokumen::active()->ordered()->get();
        return view('admin.pustaka_dokumens.edit', compact('pustakaDokumen', 'grupDokumens'));
    }

    public function update(Request $request, PustakaDokumen $pustakaDokumen)
    {
        $validated = $request->validate([
            'grup_dokumen_id' => 'required|exists:grup_dokumens,id',
            'nama_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'nomor' => 'nullable|string|max:100',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'link_type' => 'required|in:file,link',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'link_url' => 'nullable|required_if:link_type,link|url',
        ]);

        if ($request->link_type === 'file') {
            if ($request->hasFile('file')) {
                // Delete old file
                if ($pustakaDokumen->file && Storage::disk('public')->exists($pustakaDokumen->file)) {
                    Storage::disk('public')->delete($pustakaDokumen->file);
                }
                
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $filename = Str::slug($validated['nama_dokumen']) . '-' . time() . '.' . $extension;
                $path = $file->storeAs('pustaka-dokumen', $filename, 'public');
                $validated['file'] = $path;
                $validated['ukuran'] = $this->formatFileSize($file->getSize());
                $validated['link_url'] = null;
            }
        } else {
            // If switching to link type
            $validated['file'] = null;
            $validated['link_url'] = $request->link_url;
        }

        $pustakaDokumen->update($validated);

        return redirect()->route('admin.pustaka-dokumens.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(PustakaDokumen $pustakaDokumen)
    {
        // Delete file if exists
        if ($pustakaDokumen->file && Storage::disk('public')->exists($pustakaDokumen->file)) {
            Storage::disk('public')->delete($pustakaDokumen->file);
        }

        $pustakaDokumen->delete();

        return redirect()->route('admin.pustaka-dokumens.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    private function formatFileSize($bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
