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
    </div>

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
        });
    </script>
@endsection
