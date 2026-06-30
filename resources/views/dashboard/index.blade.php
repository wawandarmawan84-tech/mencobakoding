@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- Statistik Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            {{-- Card: Total Pengaduan --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Total Pengaduan</p>
                <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalPengaduan }}</p>
            </div>

            {{-- Card: Menunggu --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Menunggu</p>
                <p class="mt-4 text-3xl font-semibold text-amber-500">{{ $menunggu }}</p>
            </div>

            {{-- Card: Diproses --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Diproses</p>
                <p class="mt-4 text-3xl font-semibold text-sky-500">{{ $diproses }}</p>
            </div>

            {{-- Card: Selesai --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Selesai</p>
                <p class="mt-4 text-3xl font-semibold text-emerald-500">{{ $selesai }}</p>
            </div>
        </div>

        {{-- Charts Grid --}}
        <div class="grid gap-6 md:grid-cols-2">
            {{-- Chart: Pengaduan per Bulan --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-slate-900">Pengaduan Per Bulan</h3>
                    <p class="mt-1 text-sm text-slate-500">Tren pengaduan selama 12 bulan terakhir.</p>
                </div>

                <div class="relative h-80 w-full">
                    <canvas id="chartPengaduanPerBulan"></canvas>
                </div>
            </div>

            {{-- Chart: Status Pengaduan (Donut) --}}
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-slate-900">Status Pengaduan</h3>
                    <p class="mt-1 text-sm text-slate-500">Distribusi status pengaduan saat ini dengan persentase.</p>
                </div>

                <div class="relative h-80 w-full">
                    <canvas id="chartStatusPengaduan"></canvas>
                </div>
            </div>
        </div>

        {{-- Statistik Per Kategori --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Statistik Per Kategori</h3>
                <p class="mt-1 text-sm text-slate-500">Distribusi pengaduan berdasarkan kategori dengan persentase.</p>
            </div>

            @if ($kategoriStats->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($kategoriStats as $kategori)
                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-sm font-semibold text-slate-700">{{ $kategori['nama_kategori'] }}</span>
                                <span class="text-sm text-slate-500">{{ $kategori['total'] }} pengaduan · {{ $kategori['persentase'] }}%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-2.5 rounded-full bg-sky-500" style="width: {{ min($kategori['persentase'], 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-slate-500">Belum ada data pengaduan untuk ditampilkan.</p>
            @endif
        </div>

        {{-- Tabel: 5 Pengaduan Terbaru --}}
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Pengaduan Terbaru</h3>
                <p class="mt-1 text-sm text-slate-500">5 pengaduan terakhir dari masyarakat.</p>
            </div>

            <div class="flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Nomor Aduan</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach ($latestPengaduan as $item)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-slate-900">{{ $item['nomor'] }}</td>
                                        <td class="px-4 py-4 text-sm text-slate-700">{{ $item['judul'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 text-sm">
                                            @if ($item['status'] === 'menunggu')
                                                <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                                    ● Menunggu
                                                </span>
                                            @elseif ($item['status'] === 'diproses')
                                                <span class="inline-flex items-center rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                                    ● Diproses
                                                </span>
                                            @elseif ($item['status'] === 'selesai')
                                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                    ✓ Selesai
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                    ✕ Ditolak
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $statusTotal = max(1, $menunggu + $diproses + $selesai + ($ditolak ?? 0));
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chartPengaduanPerBulan').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($pengaduanPerBulan as $item)
                            '{{ $item['bulan'] }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Jumlah Pengaduan',
                            data: [
                                @foreach($pengaduanPerBulan as $item)
                                    {{ $item['jumlah'] }},
                                @endforeach
                            ],
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            borderRadius: 6,
                            hoverBackgroundColor: 'rgba(59, 130, 246, 0.8)',
                            hoverBorderColor: 'rgba(59, 130, 246, 1)',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: 'rgba(100, 116, 139, 1)',
                                font: {
                                    size: 13,
                                    weight: '500'
                                },
                                padding: 15,
                                usePointStyle: true,
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 13,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            borderColor: 'rgba(59, 130, 246, 0.5)',
                            borderWidth: 1,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    return 'Pengaduan: ' + context.parsed.y + ' laporan';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            ticks: {
                                color: 'rgba(100, 116, 139, 0.7)',
                                font: {
                                    size: 12
                                },
                                stepSize: 2
                            },
                            grid: {
                                color: 'rgba(51, 65, 85, 0.1)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: 'rgba(100, 116, 139, 0.7)',
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            // Chart: Status Pengaduan (Donut)
            const ctxStatus = document.getElementById('chartStatusPengaduan').getContext('2d');
            const totalStatus = {{ $statusTotal }};
            const pctMenunggu = Math.round(({{ $menunggu }} / totalStatus) * 100);
            const pctDiproses = Math.round(({{ $diproses }} / totalStatus) * 100);
            const pctSelesai = Math.round(({{ $selesai }} / totalStatus) * 100);

            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: [
                        'Menunggu (' + pctMenunggu + '%)',
                        'Diproses (' + pctDiproses + '%)',
                        'Selesai (' + pctSelesai + '%)'
                    ],
                    datasets: [
                        {
                            label: 'Pengaduan',
                            data: [
                                {{ $menunggu }},
                                {{ $diproses }},
                                {{ $selesai }}
                            ],
                            backgroundColor: [
                                'rgba(251, 191, 36, 0.7)',      // Amber - Menunggu
                                'rgba(14, 165, 233, 0.7)',      // Sky - Diproses
                                'rgba(16, 185, 129, 0.7)',      // Emerald - Selesai
                            ],
                            borderColor: [
                                'rgba(251, 191, 36, 1)',        // Amber
                                'rgba(14, 165, 233, 1)',        // Sky
                                'rgba(16, 185, 129, 1)',        // Emerald
                            ],
                            borderWidth: 2,
                            hoverBackgroundColor: [
                                'rgba(251, 191, 36, 0.9)',
                                'rgba(14, 165, 233, 0.9)',
                                'rgba(16, 185, 129, 0.9)',
                            ],
                            hoverBorderColor: [
                                'rgba(251, 191, 36, 1)',
                                'rgba(14, 165, 233, 1)',
                                'rgba(16, 185, 129, 1)',
                            ]
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: 'rgba(100, 116, 139, 1)',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 15,
                                usePointStyle: true,
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 13,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            borderColor: 'rgba(100, 116, 139, 0.5)',
                            borderWidth: 1,
                            displayColors: true,
                            callbacks: {
                                label: function (context) {
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return context.label.split('(')[0].trim() + ': ' + value + ' laporan (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
