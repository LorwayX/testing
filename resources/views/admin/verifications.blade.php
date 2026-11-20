@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-1" style="font-family:'Playfair Display', serif;">Verifikasi Prestasi</h3>
        <p class="text-muted small mb-0">Tinjau bukti sebelum menyetujui pengajuan prestasi siswa</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
@endif

<!-- Tab Filter Status -->
<div class="d-flex gap-2 mb-4">
    <a href="{{ route('admin.verifications', ['status' => 'pending']) }}" class="btn btn-sm rounded-pill px-3 fw-semibold shadow-sm {{ ($status ?? 'pending') === 'pending' ? 'btn-warning text-white' : 'btn-light text-muted border' }}" style="{{ ($status ?? 'pending') === 'pending' ? 'background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;' : '' }}">
        Menunggu ({{ $pendingCount ?? 0 }})
    </a>
    <a href="{{ route('admin.verifications', ['status' => 'approved']) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ ($status ?? '') === 'approved' ? 'btn-success text-white' : 'btn-light text-muted border' }}">
        Disetujui ({{ $approvedCount ?? 0 }})
    </a>
    <a href="{{ route('admin.verifications', ['status' => 'rejected']) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ ($status ?? '') === 'rejected' ? 'btn-danger text-white' : 'btn-light text-muted border' }}">
        Ditolak ({{ $rejectedCount ?? 0 }})
    </a>
</div>

<!-- Tabel Verifikasi -->
<div class="bg-white rounded-4 shadow-sm overflow-hidden border p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small uppercase" style="font-size: 0.7rem;">
                <tr>
                    <th class="py-3 px-3">SISWA</th>
                    <th>JUDUL</th>
                    <th>TINGKAT</th>
                    <th>DIAJUKAN</th>
                    <th class="text-end px-3">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($verificationsList ?? [] as $item)
                @php
                    $userName = $item->user ? $item->user->name : 'Siswa';
                    $userInitials = substr($userName, 0, 2);
                    $formattedDate = $item->achievement_date ? \Carbon\Carbon::parse($item->achievement_date)->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y');
                @endphp
                <tr>
                    <td class="px-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:32px; height:32px; font-size:0.75rem; background: linear-gradient(135deg, #fbbf24, #d97706) !important;">
                                {{ $userInitials }}
                            </div>
                            <div>
                                <span class="fw-bold d-block" style="font-size: 0.85rem;">{{ $userName }}</span>
                                <small class="text-muted" style="font-size: 0.7rem;">{{ $item->user->class_name ?? 'XI PPLG' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-semibold d-block" style="font-size: 0.85rem;">{{ $item->title }}</span>
                        <small class="text-muted" style="font-size: 0.7rem;">{{ $item->category }} • {{ $item->result }} • +{{ $item->points }} Poin</small>
                    </td>
                    <td><span class="badge bg-warning-subtle text-warning border px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">{{ $item->level }}</span></td>
                    <td><span class="text-muted small" style="font-size: 0.8rem;">{{ $formattedDate }}</span></td>
                    <td class="text-end px-3">
                        <div class="d-flex justify-content-end align-items-center gap-1">
                            @if($item->evidence_path)
                                <a href="{{ asset('storage/' . $item->evidence_path) }}" target="_blank" class="btn btn-sm btn-light rounded-circle text-primary border shadow-sm" title="Lihat Bukti Sertifikat">
                                    <i class="bi bi-file-earmark-text"></i>
                                </a>
                            @endif

                            @if($item->verification_status !== 'approved')
                                <form action="{{ route('admin.verify', $item->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success rounded-circle text-white shadow-sm border-0" title="Setujui"><i class="bi bi-check-lg"></i></button>
                                </form>
                            @endif

                            @if($item->verification_status !== 'rejected')
                                <form action="{{ route('admin.verify', $item->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger rounded-circle text-white shadow-sm border-0" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Tidak ada data verifikasi untuk status ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
