@extends('layouts.student')
@section('content')
<div class="bg-white p-4 rounded-4 shadow-sm border mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-4 shadow-sm" style="width:60px; height:60px; background: linear-gradient(135deg, #fbbf24, #d97706) !important;">
            {{ substr($userName, 0, 2) }}
        </div>
        <div>
            <h4 class="fw-bold mb-1">{{ $userName }}</h4>
            <span class="text-muted small">Siswa {{ $userClass }} • NIS {{ $userNis ?? '-' }}</span>
        </div>
    </div>
    <button class="btn btn-warning text-white rounded-pill px-4 fw-semibold shadow-sm" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan profil berhasil disalin ke clipboard!');" style="background: linear-gradient(90deg, #ff9e2c 0%, #ff6f00 100%); border:none;"><i class="bi bi-share me-1"></i> Bagikan Profil</button>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="bg-white p-3 rounded-4 shadow-sm border text-center">
            <small class="text-muted d-block mb-1">Prestasi Disetujui</small>
            <h4 class="fw-bold mb-0">{{ $totalPrestasi ?? 0 }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white p-3 rounded-4 shadow-sm border text-center">
            <small class="text-muted d-block mb-1">Total Poin</small>
            <h4 class="fw-bold mb-0 text-warning">{{ $totalPoints ?? 0 }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white p-3 rounded-4 shadow-sm border text-center">
            <small class="text-muted d-block mb-1">Peringkat Sekolah</small>
            <h4 class="fw-bold mb-0">#{{ $myRank ?? 1 }}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white p-3 rounded-4 shadow-sm border text-center">
            <small class="text-muted d-block mb-1">Status Portofolio</small>
            <h4 class="fw-bold mb-0 text-success">Aktif</h4>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h6 class="fw-bold mb-3">Daftar Prestasi Terverifikasi</h6>
            <div class="d-flex flex-column gap-3">
                @forelse($userAchievements ?? [] as $item)
                <div class="p-3 rounded-3 bg-light border d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="fw-bold" style="font-size: 0.9rem;">{{ $item['title'] }}</div>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $item['date'] }} • {{ $item['level'] }} • {{ $item['category'] }} • +{{ $item['points'] }} Poin</small>
                    </div>
                    @if(!empty($item['evidence_path']))
                        <a href="{{ asset('storage/' . $item['evidence_path']) }}" target="_blank" class="btn btn-sm btn-light border text-danger fw-semibold" style="font-size: 0.75rem;"><i class="bi bi-file-earmark-pdf me-1"></i> Sertifikat</a>
                    @else
                        <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">Terverifikasi Sekolah</span>
                    @endif
                </div>
                @empty
                <div class="p-4 text-center text-muted">Belum ada prestasi terverifikasi yang dipublikasikan.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border mb-3">
            <h6 class="fw-bold mb-2">Tentang Siswa</h6>
            <p class="text-muted small mb-0">Siswa aktif berprestasi pada bidang akademik dan non-akademik di SMK Metland Cibitung.</p>
        </div>
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <h6 class="fw-bold mb-2">Kontak Email</h6>
            <p class="text-muted small mb-0">{{ $student->email ?? 'siswa@achievo.test' }}</p>
        </div>
    </div>
</div>
@endsection
