@extends('layouts.student')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Prestasi Saya</h3>
        <p class="text-muted small mb-0">{{ count($achievements ?? []) }} Prestasi tercatat</p>
    </div>
    <a href="{{ route('achievements.create') }}" class="btn btn-warning text-white rounded-pill px-4 fw-semibold shadow-sm" style="background: linear-gradient(90deg, #ff9e2c 0%, #ff6f00 100%); border:none;"><i class="bi bi-plus me-1"></i> Tambah Prestasi</a>
</div>

<div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
    <form method="GET" action="{{ route('achievements.index') }}" class="mb-3">
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3"><i class="bi bi-search text-muted"></i></span>
            <input type="text" name="search" class="form-control bg-light border-start-0 rounded-end-pill py-2" placeholder="Cari Prestasi berdasarkan judul..." value="{{ request('search') }}">
        </div>
    </form>
    <div class="d-flex gap-2">
        <a href="{{ route('achievements.index') }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ !request('status') ? 'btn-warning text-white' : 'btn-light text-muted border' }}">Semua</a>
        <a href="{{ route('achievements.index', ['status' => 'approved', 'search' => request('search')]) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ request('status') === 'approved' ? 'btn-success text-white' : 'btn-light text-muted border' }}">Terverifikasi</a>
        <a href="{{ route('achievements.index', ['status' => 'pending', 'search' => request('search')]) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ request('status') === 'pending' ? 'btn-warning text-white' : 'btn-light text-muted border' }}">Menunggu</a>
        <a href="{{ route('achievements.index', ['status' => 'rejected', 'search' => request('search')]) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ request('status') === 'rejected' ? 'btn-danger text-white' : 'btn-light text-muted border' }}">Ditolak</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-4 shadow-sm overflow-hidden border">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small uppercase" style="font-size: 0.7rem;">
            <tr>
                <th class="py-3 px-4">JUDUL</th>
                <th>KATEGORI</th>
                <th>TINGKAT</th>
                <th>STATUS</th>
                <th>POIN</th>
                <th class="text-end px-4">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($achievements ?? [] as $item)
            @php
                $title = is_object($item) ? $item->title : $item['title'];
                $category = is_object($item) ? $item->category : $item['category'];
                $level = is_object($item) ? $item->level : $item['level'];
                $points = is_object($item) ? $item->points : $item['points'];
                $status = is_object($item) ? ($item->verification_status ?? $item->status) : ($item['verification_status'] ?? $item['status'] ?? 'pending');
                $itemId = is_object($item) ? $item->id : $item['id'];
                $evidencePath = is_object($item) ? $item->evidence_path : ($item['evidence_path'] ?? null);
                $dateRaw = is_object($item) ? ($item->achievement_date ?? $item->created_at) : ($item['achievement_date'] ?? $item['date'] ?? null);
                $displayDate = $dateRaw ? \Carbon\Carbon::parse($dateRaw)->translatedFormat('d M Y') : '-';
            @endphp
            <tr>
                <td class="px-4">
                    <div class="fw-bold" style="font-size: 0.85rem;">{{ $title }}</div>
                    <small class="text-muted" style="font-size: 0.7rem;">{{ $displayDate }}</small>
                </td>
                <td><span class="badge bg-light text-dark border" style="font-size: 0.7rem;">{{ $category }}</span></td>
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
                <td class="fw-bold text-dark">+{{ $points }}</td>
                <td class="text-end px-4">
                    <div class="d-inline-flex gap-1 align-items-center">
                        @if($evidencePath)
                            <a href="{{ asset('storage/' . $evidencePath) }}" target="_blank" class="btn btn-sm btn-light rounded-circle text-primary border shadow-sm" title="Lihat Bukti Sertifikat"><i class="bi bi-file-earmark-text"></i></a>
                        @endif
                        <form action="{{ route('achievements.destroy', $itemId) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light rounded-circle text-danger border-0" onclick="return confirm('Hapus prestasi ini?')" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada prestasi yang ditambahkan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
