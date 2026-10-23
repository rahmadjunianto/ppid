<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regulasi;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class RegulasiController extends Controller
{
    /**
     * Display a listing of Regulasi.
     */
    public function index(Request $request)
    {
        $query = Regulasi::query();

        // Search by nama_regulasi / nomor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_regulasi', 'like', "%{$search}%")
                  ->orWhere('nomor', 'like', "%{$search}%");
            });
        }

        // Filter by tingkat
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $regulasi = $query->ordered()->paginate(15)->withQueryString();

        $tingkatOptions = Regulasi::getTingkatOptions();
        $tahunOptions   = Regulasi::getTahunOptions();

        return view('admin.regulasi.index', compact('regulasi', 'tingkatOptions', 'tahunOptions'));
    }

    /**
     * Show the form for creating a new Regulasi.
     *
     * Mendukung mode multiple form lewat query string ?jumlah=N
     * untuk menampilkan N baris form sekaligus.
     */
    public function create(Request $request)
    {
        $tingkatOptions = Regulasi::getTingkatOptions();

        // Jumlah baris awal (untuk mode multiple form)
        $jumlahRows = (int) $request->query('jumlah', 1);

        // Jika sebelumnya gagal validasi, jumlah baris mengikuti data yang dikirim
        $oldItems = $request->session()->getOldInput('items');

        if (is_array($oldItems) && count($oldItems) > $jumlahRows) {
            $jumlahRows = count($oldItems);
        }

        $jumlahRows = max(1, min($jumlahRows, 50));

        return view('admin.regulasi.create', compact('tingkatOptions', 'jumlahRows'));
    }

    /**
     * Store a newly created Regulasi in storage.
     *
     * Mendukung dua mode:
     * - Mode tunggal  : field biasa (nama_regulasi, file, dst.)
     * - Mode multiple : field berupa array (items[0][nama_regulasi], items[0][file], dst.)
     */
    public function store(Request $request)
    {
        // Mode multiple form: field berupa array (items[0][nama_regulasi], items[0][file], dst.)
        if ($request->has('items')) {
            return $this->storeMultiple($request);
        }

        $request->validate([
            'nama_regulasi' => 'required|string|max:255',
            'nomor'         => 'nullable|string|max:255',
            'tingkat'       => ['required', Rule::in(array_keys(Regulasi::getTingkatOptions()))],
            'tahun'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'link_type'     => 'required|in:file,link',
            'file'          => 'required_if:link_type,file|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'link_url'      => 'required_if:link_type,link|nullable|url|max:255',
            'status'        => 'required|in:draft,published',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['admin_id'] = auth()->id();

        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('regulasi', $filename, 'public');

            $data['file']   = $path;
            $data['ukuran'] = $file->getSize();
        }

        // Normalisasi field sesuai link_type
        if ($data['link_type'] === 'link') {
            $data['file'] = null;
        } else {
            $data['link_url'] = null;
        }

        Regulasi::create($data);

        return redirect()->route('admin.regulasi.index')
                        ->with('success', 'Regulasi berhasil ditambahkan.');
    }

    /**
     * Simpan banyak regulasi sekaligus dari satu form (multiple form).
     *
     * Field dikirim sebagai array: items[0][nama_regulasi], items[0][file], items[0][link_url], dst.
     */
    protected function storeMultiple(Request $request)
    {
        $items = $request->input('items', []);
        $files = $request->file('items', []);

        // Buang baris yang benar-benar kosong (tidak ada nama, file, maupun link).
        // Indeks asli dipertahankan agar pesan error cocok dengan baris form.
        $cleanItems = [];

        foreach ($items as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $hasName = trim((string) ($item['nama_regulasi'] ?? '')) !== '';
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
            return redirect()->route('admin.regulasi.create')
                ->withErrors(['items' => 'Minimal satu baris regulasi harus diisi (nama regulasi).'])
                ->withInput();
        }

        // Catatan: required_if wajib memakai path penuh (items.*.link_type) agar
        // berlaku di dalam array, bukan hanya di level atas.
        $rules = [
            'items'                 => 'required|array|min:1',
            'items.*.nama_regulasi' => 'required|string|max:255',
            'items.*.nomor'         => 'nullable|string|max:255',
            'items.*.tingkat'       => ['required', Rule::in(array_keys(Regulasi::getTingkatOptions()))],
            'items.*.tahun'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'items.*.link_type'     => 'required|in:file,link',
            'items.*.file'          => 'nullable|required_if:items.*.link_type,file|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'items.*.link_url'      => 'nullable|required_if:items.*.link_type,link|url|max:255',
            'items.*.status'        => 'required|in:draft,published',
            'items.*.sort_order'    => 'nullable|integer|min:0',
        ];

        // Validasi manual (data sudah dibersihkan) -> error diarahkan ke baris form yang sesuai
        Validator::make(['items' => $cleanItems], $rules)->validate();

        $success = 0;
        $failed  = [];

        DB::transaction(function () use ($cleanItems, &$success, &$failed) {
            foreach ($cleanItems as $item) {
                try {
                    $data = [
                        'nama_regulasi' => $item['nama_regulasi'],
                        'nomor'         => $item['nomor'] ?? null,
                        'tingkat'       => $item['tingkat'],
                        'tahun'         => $item['tahun'] ?? null,
                        'link_type'     => $item['link_type'],
                        'file'          => null,
                        'link_url'      => null,
                        'ukuran'        => null,
                        'status'        => $item['status'],
                        'sort_order'    => $item['sort_order'] ?? 0,
                        'admin_id'      => auth()->id(),
                    ];

                    if ($item['link_type'] === 'file') {
                        $file     = $item['file'];
                        $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                        $path     = $file->storeAs('regulasi', $filename, 'public');

                        $data['file']   = $path;
                        $data['ukuran'] = $file->getSize();
                    } else {
                        $data['link_url'] = $item['link_url'];
                    }

                    Regulasi::create($data);

                    $success++;
                } catch (Throwable $e) {
                    $failed[] = ($item['nama_regulasi'] ?? 'Regulasi') . ' (' . $e->getMessage() . ')';
                }
            }
        });

        if ($success > 0) {
            $message = $success . ' regulasi berhasil ditambahkan.';

            if (count($failed) > 0) {
                $message .= ' ' . count($failed) . ' regulasi gagal disimpan.';
            }

            return redirect()->route('admin.regulasi.index')
                ->with('success', $message)
                ->with('failed_items', $failed);
        }

        return redirect()->route('admin.regulasi.index')
            ->with('error', 'Gagal menyimpan regulasi: ' . implode('; ', $failed));
    }

    /**
     * Display the specified Regulasi.
     */
    public function show($id)
    {
        $regulasi = Regulasi::findOrFail($id);

        return view('admin.regulasi.show', compact('regulasi'));
    }

    /**
     * Show the form for editing the specified Regulasi.
     */
    public function edit($id)
    {
        $regulasi      = Regulasi::findOrFail($id);
        $tingkatOptions = Regulasi::getTingkatOptions();

        return view('admin.regulasi.edit', compact('regulasi', 'tingkatOptions'));
    }

    /**
     * Update the specified Regulasi in storage.
     */
    public function update(Request $request, $id)
    {
        $regulasi = Regulasi::findOrFail($id);

        $request->validate([
            'nama_regulasi' => 'required|string|max:255',
            'nomor'         => 'nullable|string|max:255',
            'tingkat'       => ['required', Rule::in(array_keys(Regulasi::getTingkatOptions()))],
            'tahun'         => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'link_type'     => 'required|in:file,link',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'link_url'      => 'nullable|url|max:255',
            'status'        => 'required|in:draft,published',
            'sort_order'    => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            // Hapus file lama bila ada
            if ($regulasi->file) {
                Storage::disk('public')->delete($regulasi->file);
            }

            $file     = $request->file('file');
            $filename = time() . '_' . Str::random(6) . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('regulasi', $filename, 'public');

            $data['file']   = $path;
            $data['ukuran'] = $file->getSize();
        }

        // Normalisasi field sesuai link_type
        if ($data['link_type'] === 'link') {
            $data['file'] = null;
        } else {
            $data['link_url'] = null;
        }

        $regulasi->update($data);

        return redirect()->route('admin.regulasi.index')
                        ->with('success', 'Regulasi berhasil diperbarui.');
    }

    /**
     * Remove the specified Regulasi from storage.
     */
    public function destroy($id)
    {
        $regulasi = Regulasi::findOrFail($id);

        // Hapus file terkait bila ada
        if ($regulasi->file) {
            Storage::disk('public')->delete($regulasi->file);
        }

        $regulasi->delete();

        return redirect()->route('admin.regulasi.index')
                        ->with('success', 'Regulasi berhasil dihapus.');
    }
}
