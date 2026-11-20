@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Dashboard Administrator</h3>
        <p class="text-muted small mb-0">Kelola dan pantau seluruh pengajuan prestasi siswa</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <small class="text-muted d-block mb-1">Prestasi Pending (Menunggu)</small>
            <h2 class="fw-bold mb-1 text-warning">{{ $pendingCount ?? 0 }}</h2>
            <span class="text-muted" style="font-size: 0.75rem;">Perlu verifikasi segera</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <small class="text-muted d-block mb-1">Total Pengajuan</small>
            <h2 class="fw-bold mb-1">{{ $totalAchievements ?? count($achievements ?? []) }}</h2>
            <span class="text-muted" style="font-size: 0.75rem;">Seluruh data masuk</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border">
            <small class="text-muted d-block mb-1">Siswa Terdaftar</small>
            <h2 class="fw-bold mb-1">{{ $totalStudents ?? 0 }}</h2>
            <span class="text-muted" style="font-size: 0.75rem;">Aktif di sistem</span>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-4 shadow-sm overflow-hidden border p-4">
    <h5 class="fw-bold mb-3">Daftar Pengajuan Prestasi Siswa</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small uppercase" style="font-size: 0.7rem;">
                <tr>
                    <th class="py-3 px-3">SISWA</th>
                    <th>JUDUL PRESTASI</th>
                    <th>TINGKAT</th>
                    <th>STATUS</th>
                    <th class="text-end px-3">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($achievements ?? [] as $item)
                @php
                    $userName = is_object($item) ? ($item->user->name ?? 'Siswa') : ($item['user'] ?? 'Siswa');
                    $userClass = is_object($item) ? ($item->user->class_name ?? 'XI PPLG') : ($item['class'] ?? 'XI PPLG');
                    $title = is_object($item) ? $item->title : $item['title'];
                    $category = is_object($item) ? $item->category : $item['category'];
                    $level = is_object($item) ? $item->level : $item['level'];
                    $points = is_object($item) ? $item->points : $item['points'];
                    $status = is_object($item) ? ($item->verification_status ?? $item->status) : ($item['verification_status'] ?? $item['status'] ?? 'pending');
                    $itemId = is_object($item) ? $item->id : $item['id'];
                    $evidencePath = is_object($item) ? $item->evidence_path : ($item['evidence_path'] ?? null);
                @endphp
                <tr>
                    <td class="px-3">
                        <div class="fw-bold" style="font-size: 0.85rem;">{{ $userName }}</div>
                        <small class="text-muted" style="font-size: 0.7rem;">{{ $userClass }}</small>
                    </td>
                    <td>
                        <div class="fw-semibold" style="font-size: 0.85rem;">{{ $title }}</div>
                        <small class="text-muted" style="font-size: 0.7rem;">{{ $category }} • +{{ $points }} Poin</small>
                    </td>
                    <td><span class="badge bg-light text-dark border" style="font-size: 0.7rem;">{{ $level }}</span></td>
                    <td>
                        @if($status == 'approved')
                            <span class="badge bg-success-subtle text-success" style="font-size: 0.65rem;">Terverifikasi</span>
                        @elseif($status == 'rejected')
                            <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">Ditolak</span>
                        @else
                            <span class="badge bg-warning-subtle text-warning" style="font-size: 0.65rem;">Menunggu</span>
                        @endif
                    </td>
                    <td class="text-end px-3">
                        <div class="d-inline-flex gap-1 align-items-center">
                            @if($evidencePath)
                                <a href="{{ asset('storage/' . $evidencePath) }}" target="_blank" class="btn btn-sm btn-light rounded-pill px-2 py-1 text-primary" style="font-size: 0.7rem;" title="Lihat Bukti"><i class="bi bi-file-earmark-text"></i> Bukti</a>
                            @endif

                            @if($status !== 'approved')
                                <form action="{{ route('admin.verify', $itemId) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-2 py-1" style="font-size: 0.7rem;" title="Setujui"><i class="bi bi-check"></i> Setujui</button>
                                </form>
                            @endif

                            @if($status !== 'rejected')
                                <form action="{{ route('admin.verify', $itemId) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-2 py-1" style="font-size: 0.7rem;" title="Tolak"><i class="bi bi-x"></i>Tolak</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada pengajuan prestasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
