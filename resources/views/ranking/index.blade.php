@extends('layouts.student')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Papan Peringkat Prestasi</h3>
        <p class="text-muted small mb-0">Tahun Ajaran 2026/2027 — Peringkat berdasarkan akumulasi poin prestasi terverifikasi</p>
    </div>
</div>

<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="{{ route('ranking') }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ empty($category) ? 'btn-warning text-white' : 'btn-light text-muted border' }}" style="{{ empty($category) ? 'background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;' : '' }}">Keseluruhan</a>
    <a href="{{ route('ranking', ['category' => 'Teknologi']) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ ($category ?? '') === 'Teknologi' ? 'btn-warning text-white' : 'btn-light text-muted border' }}" style="{{ ($category ?? '') === 'Teknologi' ? 'background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;' : '' }}">Teknologi</a>
    <a href="{{ route('ranking', ['category' => 'Akademik']) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ ($category ?? '') === 'Akademik' ? 'btn-warning text-white' : 'btn-light text-muted border' }}" style="{{ ($category ?? '') === 'Akademik' ? 'background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;' : '' }}">Akademik</a>
    <a href="{{ route('ranking', ['category' => 'Olahraga']) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ ($category ?? '') === 'Olahraga' ? 'btn-warning text-white' : 'btn-light text-muted border' }}" style="{{ ($category ?? '') === 'Olahraga' ? 'background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;' : '' }}">Olahraga</a>
    <a href="{{ route('ranking', ['category' => 'Seni & Kreativitas']) }}" class="btn btn-sm rounded-pill px-3 fw-semibold {{ ($category ?? '') === 'Seni & Kreativitas' ? 'btn-warning text-white' : 'btn-light text-muted border' }}" style="{{ ($category ?? '') === 'Seni & Kreativitas' ? 'background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;' : '' }}">Seni</a>
</div>

<!-- Top 3 Podium Cards -->
<div class="row g-3 mb-4">
    @foreach(array_slice($leaderboard ?? [], 0, 3) as $index => $row)
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border text-center position-relative">
            <div class="bg-warning text-white rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; background: linear-gradient(135deg, #fbbf24, #d97706) !important;">{{ substr($row['name'], 0, 2) }}</div>
            <h6 class="fw-bold mb-1">
                <a href="{{ route('profile.public', $row['username'] ?? $row['id']) }}" class="text-decoration-none text-dark">{{ $row['name'] }}</a>
            </h6>
            <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">{{ $row['class'] }}</small>
            <div class="fw-bold fs-4 text-warning">{{ $row['points'] }} <span class="fs-6 text-muted">pts</span></div>
            <span class="badge bg-warning-subtle text-warning rounded-pill px-3" style="font-size: 0.65rem;">#{{ $index + 1 }}</span>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-4 shadow-sm overflow-hidden border">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small uppercase" style="font-size: 0.7rem;">
            <tr>
                <th class="py-3 px-4">RANK</th>
                <th>SISWA</th>
                <th>KELAS</th>
                <th>POIN</th>
                <th class="text-end px-4">PRESTASI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaderboard ?? [] as $index => $row)
            <tr>
                <td class="px-4 fw-bold text-muted">#{{ $index + 1 }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center fw-bold small" style="width:28px; height:28px; font-size:0.7rem; background: linear-gradient(135deg, #fbbf24, #d97706) !important;">{{ substr($row['name'], 0, 2) }}</div>
                        <a href="{{ route('profile.public', $row['username'] ?? $row['id']) }}" class="fw-bold text-decoration-none text-dark" style="font-size: 0.85rem;">{{ $row['name'] }}</a>
                    </div>
                </td>
                <td class="text-muted" style="font-size: 0.8rem;">{{ $row['class'] }}</td>
                <td class="fw-bold text-dark">{{ $row['points'] }}</td>
                <td class="text-end px-4 text-muted" style="font-size: 0.8rem;">{{ $row['achievements_count'] ?? 0 }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-muted">Belum ada siswa yang memiliki prestasi disetujui.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
