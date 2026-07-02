<?php

namespace App\Notifications;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage; // Import for database notification
use Illuminate\Notifications\Notification;

class PengaduanAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Pengaduan $pengaduan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Laporan "' . $this->pengaduan->judul . '" telah ditugaskan kepada Anda.',
            'pengaduan_id' => $this->pengaduan->id,
            'nomor_aduan' => $this->pengaduan->nomor_aduan,
            'url' => route('pengaduan.show', $this->pengaduan),
        ];
    }
}
