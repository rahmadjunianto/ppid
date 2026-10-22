<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sop;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class SopController extends Controller
{
    /**
     * Display a listing of SOP.
     */
    public function index(Request $request)
    {
        $query = Sop::query();

        // Search by nama_dokumen
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_dokumen', 'like', "%{$search}%")
                  ->orWhere('nomor', 'like', "%{$search}%");
            });
        }

        // Filter by grup
        if ($request->filled('grup')) {
            $query->where('grup', $request->grup);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $sops = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);
        $grupOptions = Sop::getGrupOptions();
        $tahunOptions = Sop::getTahunOptions();

        return view('admin.sops.index', compact('sops', 'grupOptions', 'tahunOptions'));
    }

    /**
     * Show the form for creating a new SOP.
     */
    public function create(Request $request)
    {
        $grupOptions = Sop::getGrupOptions();

        // Jumlah baris awal (untuk mode multiple form)
        $jumlahRows = (int) $request->query('jumlah', 1);

        // Jika sebelumnya gagal validasi, jumlah baris mengikuti data yang dikirim
        $oldItems = $request->session()->getOldInput('items');

        if (is_array($oldItems) && count($oldItems) > $jumlahRows) {
            $jumlahRows = count($oldItems);
        }

        $jumlahRows = max(1, min($jumlahRows, 50));

        return view('admin.sops.create', compact('grupOptions', 'jumlahRows'));
    }

    /**
     * Store a newly created SOP in storage.
     *
     * Mendukung dua mode:
     * - Mode tunggal  : field biasa (nama_dokumen, file, dst.)
     * - Mode multiple : field berupa array (items[0][nama_dokumen], items[0][file], dst.)
     */
    public function store(Request $request)
    {
        if ($request->has('items')) {
            return $this->storeMultiple($request);
        }

        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'grup' => ['required', Rule::in(array_keys(Sop::getGrupOptions()))],
            'nomor' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth()->id();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sops', $filename, 'public');
            $data['file'] = $path;
            $data['ukuran'] = $file->getSize();
        }

        Sop::create($data);

        return redirect()->route('admin.sops.index')
                        ->with('success', 'SOP berhasil ditambahkan.');
    }

    /**
     * Simpan banyak SOP sekaligus dari satu form (multiple form).
     */
    protected function storeMultiple(Request $request)
    {
        $items = $request->input('items', []);
        $files = $request->file('items', []);

        // Buang baris yang benar-benar kosong (tidak ada nama dokumen maupun file)
        // Indeks asli dipertahankan agar pesan error cocok dengan baris form.
        $cleanItems = [];

        foreach ($items as $index => $item) {
            $hasName = trim((string) ($item['nama_dokumen'] ?? '')) !== '';
            $upload  = $files[$index]['file'] ?? null;
            $hasFile = $upload instanceof UploadedFile
                && $upload->getError() === UPLOAD_ERR_OK
                && $upload->getSize() > 0;

            if (! $hasName && ! $hasFile) {
                continue;
            }

            $item['file'] = $hasFile ? $upload : null;
            $cleanItems[$index] = $item;
        }

        // Tidak ada baris yang terisi sama sekali
        if (count($cleanItems) === 0) {
            return redirect()->route('admin.sops.create')
                ->withErrors(['items' => 'Minimal satu baris SOP harus diisi (nama dokumen dan file).'])
                ->withInput();
        }

        $rules = [
            'items'                  => 'required|array|min:1',
            'items.*.nama_dokumen'   => 'required|string|max:255',
            'items.*.grup'           => ['required', Rule::in(array_keys(Sop::getGrupOptions()))],
            'items.*.nomor'          => 'nullable|string|max:255',
            'items.*.tahun'          => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'items.*.file'           => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'items.*.status'         => 'required|in:draft,published',
            'items.*.sort_order'     => 'nullable|integer|min:0',
        ];

        // Validasi manual (data sudah dibersihkan) -> error diarahkan ke baris form yang sesuai
        Validator::make(['items' => $cleanItems], $rules)->validate();

        $success = 0;
        $failed  = [];

        DB::transaction(function () use ($cleanItems, &$success, &$failed) {
            foreach ($cleanItems as $item) {
                $file = $item['file'];

                try {
                    $originalName = $file->getClientOriginalName();
                    $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('sops', $filename, 'public');

                    Sop::create([
                        'nama_dokumen' => $item['nama_dokumen'],
                        'grup'         => $item['grup'],
                        'nomor'        => $item['nomor'] ?? null,
                        'tahun'        => $item['tahun'] ?? null,
                        'file'         => $path,
                        'ukuran'       => $file->getSize(),
                        'status'       => $item['status'],
                        'sort_order'   => $item['sort_order'] ?? 0,
                        'admin_id'     => auth()->id(),
                    ]);

                    $success++;
                } catch (Throwable $e) {
                    $failed[] = ($item['nama_dokumen'] ?? 'Dokumen') . ' (' . $e->getMessage() . ')';
                }
            }
        });

        if ($success > 0) {
            $message = $success . ' SOP berhasil ditambahkan.';

            if (count($failed) > 0) {
                $message .= ' ' . count($failed) . ' dokumen gagal disimpan.';
            }

            return redirect()->route('admin.sops.index')
                ->with('success', $message)
                ->with('failed_items', $failed);
        }

        return redirect()->route('admin.sops.index')
            ->with('error', 'Gagal menyimpan SOP: ' . implode('; ', $failed));
    }

    /**
     * Display the specified SOP.
     */
    public function show(Sop $sop)
    {
        return view('admin.sops.show', compact('sop'));
    }

    /**
     * Show the form for editing the specified SOP.
     */
    public function edit(Sop $sop)
    {
        $grupOptions = Sop::getGrupOptions();
        return view('admin.sops.edit', compact('sop', 'grupOptions'));
    }

    /**
     * Update the specified SOP in storage.
     */
    public function update(Request $request, Sop $sop)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'grup' => ['required', Rule::in(array_keys(Sop::getGrupOptions()))],
            'nomor' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        // Handle file upload (replace old file)
        if ($request->hasFile('file')) {
            // Delete old file
            if ($sop->file && Storage::disk('public')->exists($sop->file)) {
                Storage::disk('public')->delete($sop->file);
            }

            $file = $request->file('file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sops', $filename, 'public');
            $data['file'] = $path;
            $data['ukuran'] = $file->getSize();
        } else {
            // Keep existing file fields
            unset($data['file']);
            unset($data['ukuran']);
        }

        $sop->update($data);

        return redirect()->route('admin.sops.index')
                        ->with('success', 'SOP berhasil diperbarui.');
    }

    /**
     * Remove the specified SOP from storage.
     */
    public function destroy(Sop $sop)
    {
        // Delete file
        if ($sop->file && Storage::disk('public')->exists($sop->file)) {
            Storage::disk('public')->delete($sop->file);
        }

        $sop->delete();

        return redirect()->route('admin.sops.index')
                        ->with('success', 'SOP berhasil dihapus.');
    }
}

