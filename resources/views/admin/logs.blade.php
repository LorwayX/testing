@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-1">Log Aktivitas</h3>
        <p class="text-muted small mb-0">Riwayat tindakan administrator dan aktivitas penting sistem</p>
    </div>
</div>

<div class="bg-white rounded-4 shadow-sm overflow-hidden border p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted small uppercase" style="font-size: 0.7rem;">
                <tr>
                    <th class="py-3 px-4">WAKTU</th>
                    <th>ADMIN / PENGGUNA</th>
                    <th>AKTIVITAS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs ?? [] as $log)
                <tr>
                    <td class="px-4 text-muted small" style="white-space: nowrap;">
                        {{ $log->created_at ? $log->created_at->translatedFormat('d M Y, H:i') : '-' }}
                    </td>
                    <td class="fw-bold" style="font-size: 0.85rem;">
                        {{ $log->user ? $log->user->name : 'Sistem' }}
                    </td>
                    <td style="font-size: 0.85rem;">
                        {{ $log->action }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-muted">Belum ada catatan log aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages())
        <div class="p-3">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
