<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $pengaduanQuery = Pengaduan::query();

        $totalPengaduan = (clone $pengaduanQuery)->count();
        $menunggu = (clone $pengaduanQuery)->where('status', 'menunggu')->count();
        $diproses = (clone $pengaduanQuery)->where('status', 'diproses')->count();
        $selesai = (clone $pengaduanQuery)->where('status', 'selesai')->count();
        $ditolak = (clone $pengaduanQuery)->where('status', 'ditolak')->count();

        $pengaduanPerBulan = [];
        $now = Carbon::now();

        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $start = $date->copy()->startOfMonth()->startOfDay();
            $end = $date->copy()->endOfMonth()->endOfDay();

            $pengaduanPerBulan[] = [
                'bulan' => $date->format('M'),
                'jumlah' => Pengaduan::whereBetween('created_at', [$start, $end])->count(),
            ];
        }

        $latestPengaduan = Pengaduan::query()
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (Pengaduan $pengaduan) => [
                'nomor' => $pengaduan->nomor_aduan,
                'judul' => $pengaduan->judul,
                'status' => $pengaduan->status,
            ])
            ->toArray();

        return view('dashboard.index', compact(
            'totalPengaduan',
            'menunggu',
            'diproses',
            'selesai',
            'ditolak',
            'pengaduanPerBulan',
            'latestPengaduan'
        ));
    }
}
