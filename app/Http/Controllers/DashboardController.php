<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPengaduan = 42;
        $menunggu = 15;
        $diproses = 20;
        $selesai = 7;

        $latestPengaduan = [
            ['nomor' => 'ADU-2025-038', 'judul' => 'Jalan rusak di RW 03', 'status' => 'menunggu'],
            ['nomor' => 'ADU-2025-039', 'judul' => 'Lampu jalan padam', 'status' => 'diproses'],
            ['nomor' => 'ADU-2025-040', 'judul' => 'Sampah menumpuk di selokan', 'status' => 'selesai'],
            ['nomor' => 'ADU-2025-041', 'judul' => 'Air PDAM tidak mengalir', 'status' => 'menunggu'],
            ['nomor' => 'ADU-2025-042', 'judul' => 'Laporan keamanan ronda malam', 'status' => 'diproses'],
        ];

        return view('dashboard.index', compact(
            'totalPengaduan',
            'menunggu',
            'diproses',
            'selesai',
            'latestPengaduan'
        ));
    }
}
