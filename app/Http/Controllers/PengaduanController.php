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
        ]);

        $validated['user_id'] = auth()->id();
        $validated['nomor_aduan'] = Pengaduan::generateNomor();
        $validated['status'] = 'menunggu';

        Pengaduan::create($validated);

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim.');
    }
}
