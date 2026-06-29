<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_id' => ['required', 'integer', 'exists:kategoris,id'],
            'judul' => ['required', 'string', 'max:255'],
            'isi_pengaduan' => ['required', 'string'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'prioritas' => ['nullable', 'in:rendah,normal,tinggi,darurat'],
            'lampiran' => ['nullable', 'array'],
            'lampiran.*' => ['file', 'mimes:jpg,jpeg,png,gif,pdf', 'max:5120'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['nomor_aduan'] = Pengaduan::generateNomor();
        $validated['status'] = 'menunggu';

        $pengaduan = Pengaduan::create($validated);

        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store("public/pengaduan/{$validated['user_id']}");

                $pengaduan->lampiran()->create([
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => str_replace('public/', '', $path),
                    'tipe_file' => $file->getClientMimeType(),
                    'ukuran_file' => $file->getSize(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Display a listing of the authenticated user's pengaduan with filters.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();

        $status = $request->query('status');
        $kategoriId = $request->query('kategori_id');

        $query = Pengaduan::where('user_id', $userId);

        if ($status) {
            $query->where('status', $status);
        }

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        $pengaduans = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        $kategoris = Kategori::where('is_active', 1)->orderBy('nama_kategori')->get();

        return view('pengaduan.index', compact('pengaduans', 'kategoris'));
    }

    /**
     * Display the detail page for a single pengaduan.
     */
    public function show(Pengaduan $pengaduan)
    {
        $user = auth()->user();

        abort_unless(
            $pengaduan->user_id === $user->id || $user->isPetugas() || $user->isAdmin(),
            403
        );

        $pengaduan->load(['kategori', 'lampiran', 'petugas']);

        return view('pengaduan.show', compact('pengaduan'));
    }

    /**
     * Update status and note for a pengaduan by petugas.
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        abort_unless(auth()->user()->isPetugas(), 403);

        $validated = $request->validate([
            'status' => ['required', 'in:menunggu,diproses,selesai,ditolak'],
            'catatan_petugas' => ['nullable', 'string'],
        ]);

        $pengaduan->update([
            'status' => $validated['status'],
            'catatan_petugas' => $validated['catatan_petugas'] ?? null,
            'petugas_id' => auth()->id(),
            'tanggal_selesai' => $validated['status'] === 'selesai' ? now()->toDateString() : null,
        ]);

        return redirect()->route('pengaduan.show', $pengaduan)->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
