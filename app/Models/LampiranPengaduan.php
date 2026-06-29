<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LampiranPengaduan extends Model
{
    protected $fillable = [
        'pengaduan_id',
        'nama_file',
        'path_file',
        'tipe_file',
        'ukuran_file',
    ];

    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
