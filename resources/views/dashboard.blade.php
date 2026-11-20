@extends('layouts.student')
@section('content')
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Dashboard Siswa</h3>
        <p class="text-muted small mb-0">Ringkasan portofolio dan poin prestasi Anda</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4 mb-3">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="p-4 rounded-4 text-white shadow-sm"
                style="background: linear-gradient(135deg, #ff9e2c 0%, #ff6f00 100%);">
                <small class="text-white-50 d-block mb-1">Total Poin Diperoleh</small>
                <h2 class="fw-bold mb-1">{{ $totalPoints ?? 0 }}</h2>
                <span class="badge bg-white text-dark rounded-pill px-2 py-1" style="font-size: 0.65rem;">Poin
                    Terverifikasi</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white p-4 rounded-4 shadow-sm border">
                <small class="text-muted d-block mb-1">Prestasi Disetujui</small>
                <h2 class="fw-bold mb-1">{{ $totalVerified ?? 0 }}</h2>
                <span class="text-muted" style="font-size: 0.75rem;">Dari total {{ count($myAchievements ?? $achievements ?? []) }} pengajuan</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white p-4 rounded-4 shadow-sm border">
                <small class="text-muted d-block mb-1">Peringkat Sekolah</small>
                <h2 class="fw-bold mb-1">#{{ $myRank ?? 1 }}</h2>
                <span class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->class_name ?? 'XI PPLG' }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm border">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Prestasi Terbaru Anda</h6>
            <a href="{{ route('achievements.index') }}" class="text-decoration-none small text-warning fw-semibold">Lihat
                Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small uppercase" style="font-size: 0.7rem;">
                    <tr>
                        <th class="py-3 px-3">JUDUL</th>
                        <th>KATEGORI</th>
                        <th>TINGKAT</th>
                        <th>STATUS</th>
                        <th class="text-end">POIN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAchievements ?? [] as $item)
                        <tr>
                            <td class="px-3 fw-bold" style="font-size: 0.85rem;">{{ $item->title }}</td>
                            <td><span class="badge bg-light text-dark border"
                                    style="font-size: 0.7rem;">{{ $item->category }}</span></td>
                            <td><span class="badge bg-light text-dark border"
                                    style="font-size: 0.7rem;">{{ $item->level }}</span></td>
                            <td>
                                @if($item->verification_status === 'approved')
                                    <span class="badge bg-success-subtle text-success" style="font-size: 0.65rem;"><i class="bi bi-check-circle me-1"></i>Approved</span>
                                @elseif($item->verification_status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning" style="font-size: 0.65rem;"><i class="bi bi-clock me-1"></i>Pending</span>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-warning">+{{ $item->points }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data prestasi. Silakan tambahkan prestasi pertama Anda!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
