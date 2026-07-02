@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-cyan-300">Buat pengaduan</p>
            <h1 class="text-2xl font-semibold text-white">Buat Pengaduan Baru</h1>
            <p class="mt-1 text-sm text-slate-400">Isi laporan Anda dalam beberapa langkah dan preview lampiran sebelum submit.</p>
        </div>
        <a href="{{ route('pengaduan.index') }}" class="text-sm text-cyan-300 hover:text-cyan-200">Kembali ke Daftar</a>
    </div>

    <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data" id="pengaduanForm" class="space-y-5">
        @csrf

        <div class="rounded-[24px] border border-white/10 bg-slate-900/70 p-5 shadow-lg shadow-black/20 backdrop-blur-xl">
            <div class="grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl border p-3 text-center {{ request()->old('step', 1) == 1 ? 'border-cyan-400 bg-cyan-400/10' : 'border-white/10 bg-slate-800/50' }}">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Langkah 1</p>
                    <p class="mt-2 font-semibold text-white">Informasi</p>
                </div>
                <div class="rounded-2xl border p-3 text-center {{ request()->old('step', 1) == 2 ? 'border-cyan-400 bg-cyan-400/10' : 'border-white/10 bg-slate-800/50' }}">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Langkah 2</p>
                    <p class="mt-2 font-semibold text-white">Detail</p>
                </div>
                <div class="rounded-2xl border p-3 text-center {{ request()->old('step', 1) == 3 ? 'border-cyan-400 bg-cyan-400/10' : 'border-white/10 bg-slate-800/50' }}">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Langkah 3</p>
                    <p class="mt-2 font-semibold text-white">Lampiran</p>
                </div>
            </div>
        </div>

        <div id="step-1" class="step-panel">
            <div class="space-y-5 rounded-[24px] border border-white/10 bg-slate-900/70 p-6 shadow-lg shadow-black/20 backdrop-blur-xl">
                <div>
                    <label for="kategori_id" class="mb-2 block text-sm font-medium text-slate-200">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="mt-2 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" required>
                        <option value="">Pilih kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="judul" class="mb-2 block text-sm font-medium text-slate-200">Judul Pengaduan</label>
                    <input id="judul" name="judul" value="{{ old('judul') }}" type="text" class="mt-2 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" placeholder="Contoh: Jalan rusak di RT 05" required>
                    @error('judul')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="prioritas" class="mb-2 block text-sm font-medium text-slate-200">Prioritas</label>
                    <select id="prioritas" name="prioritas" class="mt-2 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20">
                        <option value="normal" {{ old('prioritas') === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="rendah" {{ old('prioritas') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="tinggi" {{ old('prioritas') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="darurat" {{ old('prioritas') === 'darurat' ? 'selected' : '' }}>Darurat</option>
                    </select>
                    @error('prioritas')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div id="step-2" class="step-panel hidden">
            <div class="space-y-5 rounded-[24px] border border-white/10 bg-slate-900/70 p-6 shadow-lg shadow-black/20 backdrop-blur-xl">
                <div>
                    <label for="isi_pengaduan" class="mb-2 block text-sm font-medium text-slate-200">Uraian Pengaduan</label>
                    <textarea id="isi_pengaduan" name="isi_pengaduan" rows="6" class="mt-2 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" placeholder="Jelaskan masalah secara rinci" required>{{ old('isi_pengaduan') }}</textarea>
                    @error('isi_pengaduan')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="lokasi" class="mb-2 block text-sm font-medium text-slate-200">Lokasi</label>
                        <input id="lokasi" name="lokasi" value="{{ old('lokasi') }}" type="text" class="mt-2 block w-full rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" placeholder="Contoh: Jl. Melati No. 12">
                        @error('lokasi')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-200">Koordinat (opsional)</label>
                        <div class="mt-2 grid gap-3 sm:grid-cols-2">
                            <input name="latitude" value="{{ old('latitude') }}" type="text" class="rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" placeholder="Latitude">
                            <input name="longitude" value="{{ old('longitude') }}" type="text" class="rounded-2xl border border-white/10 bg-slate-800/70 px-3 py-2.5 text-sm text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400/20" placeholder="Longitude">
                        </div>
                        @error('latitude')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                        @error('longitude')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div id="step-3" class="step-panel hidden">
            <div class="space-y-5 rounded-[24px] border border-white/10 bg-slate-900/70 p-6 shadow-lg shadow-black/20 backdrop-blur-xl">
                <div>
                    <label for="lampiran" class="mb-2 block text-sm font-medium text-slate-200">Lampiran</label>
                    <input id="lampiran" name="lampiran[]" type="file" multiple accept="image/*,.pdf" class="mt-2 block w-full text-sm text-slate-400" />
                    @error('lampiran')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                    @error('lampiran.*')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-200">Preview Lampiran</p>
                    <div id="lampiranPreview" class="mt-3 grid gap-4 sm:grid-cols-2"></div>
                </div>

                <div class="rounded-2xl border border-white/10 bg-slate-800/50 p-4 text-sm text-slate-300">
                    <p class="font-medium text-white">Ringkasan</p>
                    <p class="mt-2">Pastikan semua data sudah benar sebelum mengirim pengaduan.</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <button type="button" id="backButton" class="hidden inline-flex items-center rounded-full border border-white/10 bg-slate-800/70 px-4 py-2 text-sm text-slate-200" onclick="changeStep(-1)">Kembali</button>
            <div class="flex gap-3">
                <button type="button" id="nextButton" class="inline-flex items-center rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300" onclick="changeStep(1)">Lanjutkan</button>
                <button type="submit" id="submitButton" class="hidden inline-flex items-center rounded-full bg-emerald-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Kirim Pengaduan</button>
            </div>
        </div>
    </form>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 3;
    const stepPanels = document.querySelectorAll('.step-panel');
    const backButton = document.getElementById('backButton');
    const nextButton = document.getElementById('nextButton');
    const submitButton = document.getElementById('submitButton');
    const lampiranInput = document.getElementById('lampiran');
    const lampiranPreview = document.getElementById('lampiranPreview');

    function updateStepVisibility() {
        stepPanels.forEach((panel, index) => {
            panel.classList.toggle('hidden', index + 1 !== currentStep);
        });

        backButton.classList.toggle('hidden', currentStep === 1);
        nextButton.classList.toggle('hidden', currentStep === totalSteps);
        submitButton.classList.toggle('hidden', currentStep !== totalSteps);
    }

    function changeStep(direction) {
        const nextStep = currentStep + direction;
        if (nextStep < 1 || nextStep > totalSteps) {
            return;
        }
        currentStep = nextStep;
        updateStepVisibility();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function renderPreview(files) {
        lampiranPreview.innerHTML = '';
        if (!files.length) {
            lampiranPreview.innerHTML = '<p class="text-sm text-slate-400">Belum ada file yang dipilih.</p>';
            return;
        }

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            const previewCard = document.createElement('div');
            previewCard.className = 'rounded-2xl border border-white/10 bg-slate-800/60 p-4';

            const title = document.createElement('p');
            title.className = 'font-medium text-white';
            title.textContent = file.name;

            const meta = document.createElement('p');
            meta.className = 'mt-1 text-sm text-slate-400';
            meta.textContent = `${file.type || 'file'} • ${(file.size / 1024).toFixed(2)} KB`;

            previewCard.appendChild(title);
            previewCard.appendChild(meta);

            if (file.type.startsWith('image/')) {
                const image = document.createElement('img');
                image.className = 'mt-3 max-h-40 w-full rounded-xl object-cover border border-white/10';
                reader.onload = () => { image.src = reader.result; };
                reader.readAsDataURL(file);
                previewCard.appendChild(image);
            }

            lampiranPreview.appendChild(previewCard);
        });
    }

    lampiranInput.addEventListener('change', event => {
        renderPreview(event.target.files);
    });

    updateStepVisibility();
    renderPreview(lampiranInput.files);
</script>
@endsection