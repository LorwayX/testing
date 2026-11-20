@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0" style="font-family:'Playfair Display', serif;">Pengaturan Sistem</h3>
        <p class="text-muted small mb-0">Konfigurasi data sekolah dan operasional Achievo</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
@endif

<!-- <div class="d-flex gap-2 mb-4">
    <button class="btn btn-warning btn-sm text-white rounded-pill px-3 fw-semibold shadow-sm" style="background: linear-gradient(90deg, #f59e0b, #d97706); border:none;">Umum</button>
    <a href="{{ route('ranking') }}" class="btn btn-light btn-sm text-muted rounded-pill px-3 border text-decoration-none">Ranking</a>
    <button class="btn btn-light btn-sm text-muted rounded-pill px-3 border">Visibilitas</button>
</div> -->

<div class="bg-white p-4 rounded-4 border shadow-sm" style="max-width: 600px;">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Nama Sekolah</label>
            <input type="text" name="school_name" class="form-control rounded-pill px-3" value="{{ $schoolName ?? 'SMK Metland Cibitung' }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary">Tahun Ajaran</label>
            <select name="academic_year" class="form-select rounded-pill px-3">
                <option value="2026/2027" {{ ($academicYear ?? '2026/2027') === '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                <option value="2025/2026" {{ ($academicYear ?? '') === '2025/2026' ? 'selected' : '' }}>2025/2026</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="form-label small fw-semibold text-secondary">Deskripsi Sekolah</label>
            <textarea name="school_desc" class="form-control rounded-4 p-3" rows="3" placeholder="Deskripsi singkat yang tampil di profil siswa...">{{ $schoolDesc ?? 'Portofolio prestasi resmi siswa SMK Metland Cibitung.' }}</textarea>
        </div>
        <button type="submit" class="btn btn-warning text-white rounded-pill px-4 py-2.5 fw-semibold shadow-sm" style="background: linear-gradient(90deg, #f59e0b, #d97706); border:none;">Simpan Perubahan</button>
    </form>
</div>
@endsection
