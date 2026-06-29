<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
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
}
