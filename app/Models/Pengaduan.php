<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    protected $fillable = [
        'nomor_aduan',
        'user_id',
        'kategori_id',
        'judul',
        'isi_pengaduan',
        'lokasi',
        'latitude',
        'longitude',
        'status',
        'prioritas',
        'petugas_id',
        'tanggal_selesai',
        'catatan_petugas',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'tanggal_selesai' => 'date',
    ];

    public static function generateNomor(): string
    {
        $year = date('Y');
        $lastNomor = static::whereYear('created_at', $year)
            ->whereNotNull('nomor_aduan')
            ->orderByDesc('id')
            ->value('nomor_aduan');

        if (! $lastNomor || ! preg_match('/ADU-' . $year . '-(\d{3})$/', $lastNomor, $matches)) {
            $next = 1;
        } else {
            $next = (int) $matches[1] + 1;
        }

        return sprintf('ADU-%s-%03d', $year, $next);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function lampiran(): HasMany
    {
        return $this->hasMany(LampiranPengaduan::class);
    }
}
