<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Notifications\PengaduanAssignedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PengaduanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        try {
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
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Gagal mengirim pengaduan. Periksa kembali data yang Anda masukkan.');
        }

        try {
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
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengirim pengaduan. Silakan coba lagi.');
        }
    }

    /**
     * Display a listing of the authenticated user's pengaduan with filters.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $status = $request->query('status');
        $kategoriId = $request->query('kategori_id');
        $q = $request->query('q');

        // Admin sees all pengaduan and can dispatch; warga sees only their own
        $query = Pengaduan::with(['kategori', 'user', 'petugas']);
        if (! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($q) {
            $query->where(function ($builder) use ($q) {
                $builder->where('nomor_aduan', 'like', "%{$q}%")
                    ->orWhere('judul', 'like', "%{$q}%")
                    ->orWhere('isi_pengaduan', 'like', "%{$q}%");
            });
        }

        $pengaduans = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        $kategoris = Kategori::where('is_active', 1)->orderBy('nama_kategori')->get();

        $petugasList = [];
        if ($user->isAdmin()) {
            $petugasList = \App\Models\User::where('role', 'petugas')->orderBy('name')->get();
        }

        return view('pengaduan.index', compact('pengaduans', 'kategoris', 'petugasList'));
    }

    /**
     * AJAX search for pengaduan used by topbar suggestions.
     */
    public function search(Request $request)
    {
        $q = $request->query('q');

        if (! $q) {
            return response()->json([], 200);
        }

        $results = Pengaduan::query()
            ->where(function ($builder) use ($q) {
                $builder->where('nomor_aduan', 'like', "%{$q}%")
                    ->orWhere('judul', 'like', "%{$q}%")
                    ->orWhere('isi_pengaduan', 'like', "%{$q}%");
            })
            ->orderByDesc('created_at')
            ->limit(6)
            ->get(['id', 'nomor_aduan', 'judul', 'status', 'created_at']);

        $payload = $results->map(function ($r) {
            return [
                'id' => $r->id,
                'nomor' => $r->nomor_aduan,
                'judul' => $r->judul,
                'status' => $r->status,
                'created_at' => $r->created_at ? $r->created_at->toDateString() : null,
                'url' => route('pengaduan.show', $r->id),
            ];
        });

        return response()->json($payload, 200);
    }

    /**
     * Display the form to create a new pengaduan.
     */
    public function create()
    {
        $kategoris = Kategori::where('is_active', 1)->orderBy('nama_kategori')->get();

        return view('pengaduan.create', compact('kategoris'));
    }

    /**
     * Display the incoming pengaduan page for petugas with priority filter.
     */
    public function masuk(Request $request)
    {
        abort_unless(auth()->user()->isPetugas(), 403);

        $prioritas = $request->query('prioritas');
        $user = auth()->user();

        $query = Pengaduan::with(['kategori', 'user'])
            ->where('petugas_id', $user->id)
            ->whereIn('status', ['menunggu', 'diproses']);

        if ($prioritas) {
            $query->where('prioritas', $prioritas);
        }

        $pengaduans = $query->orderByRaw("CASE
                WHEN prioritas = 'darurat' THEN 0
                WHEN prioritas = 'tinggi' THEN 1
                WHEN prioritas = 'normal' THEN 2
                WHEN prioritas = 'rendah' THEN 3
                ELSE 4
            END")
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('pengaduan.masuk', compact('pengaduans', 'prioritas'));
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
        $user = auth()->user();

        abort_unless($user->isPetugas() || $user->isAdmin(), 403);

        if ($user->isPetugas() && $pengaduan->petugas_id !== $user->id) {
            abort(403, 'Laporan ini belum ditugaskan kepada Anda.');
        }

        try {
            $validated = $request->validate([
                'status' => ['required', 'in:menunggu,diproses,selesai,ditolak'],
                'catatan_petugas' => ['nullable', 'string'],
                'petugas_id' => ['nullable', 'integer', 'exists:users,id'],
                'evidence_photo' => ['nullable', 'file', 'image', 'max:5120'],
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Gagal memperbarui status pengaduan. Periksa data yang Anda masukkan.');
        }

        try {
            $newPetugasId = $validated['petugas_id'] ?? ($user->isPetugas() ? $user->id : $pengaduan->petugas_id);

            $pengaduan->update([
                'status' => $validated['status'],
                'catatan_petugas' => $validated['catatan_petugas'] ?? null,
                'petugas_id' => $newPetugasId,
                'tanggal_selesai' => $validated['status'] === 'selesai' ? now()->toDateString() : null,
            ]);

            if ($validated['status'] === 'selesai' && $request->hasFile('evidence_photo')) {
                $file = $request->file('evidence_photo');
                $path = $file->store("public/pengaduan/evidence/{$pengaduan->id}");

                $pengaduan->lampiran()->create([
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => str_replace('public/', '', $path),
                    'tipe_file' => $file->getClientMimeType(),
                    'ukuran_file' => $file->getSize(),
                ]);
            }

            if ($user->isAdmin() && $newPetugasId) {
                $petugas = \App\Models\User::find($newPetugasId);
                if ($petugas) {
                    $petugas->notify(new PengaduanAssignedNotification($pengaduan));
                }
            }

            return redirect()->route('pengaduan.show', $pengaduan)->with('success', 'Status pengaduan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui status pengaduan. Silakan coba lagi.');
        }
    }

    /**
     * Show status edit form for admin.
     */
    public function status(Pengaduan $pengaduan)
    {
        $user = auth()->user();

        abort_unless($user->isAdmin(), 403);

        $pengaduan->load(['kategori', 'lampiran', 'petugas', 'user']);

        $petugasList = \App\Models\User::where('role', 'petugas')->orderBy('name')->get();

        return view('pengaduan.status', compact('pengaduan', 'petugasList'));
    }
}
