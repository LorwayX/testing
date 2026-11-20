@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="fw-bold mb-1" style="font-family:'Playfair Display', serif;">Kategori Prestasi</h3>
        <p class="text-muted small mb-0">{{ count($categoriesList ?? []) }} Kategori aktif</p>
    </div>
    <button class="btn btn-warning text-white rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal" style="background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;">+ Tambah Kategori</button>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
@endif

<div class="row g-3">
    @forelse($categoriesList ?? [] as $cat)
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 border shadow-sm position-relative">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="bg-warning text-white rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" style="width:38px; height:38px; background: linear-gradient(135deg, #fbbf24, #d97706) !important;"><i class="bi bi-tag-fill"></i></div>
                <div>
                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light rounded-circle text-danger border shadow-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
            <h6 class="fw-bold mb-0">{{ $cat->name }}</h6>
            <small class="text-muted d-block mb-3" style="font-size:0.75rem;">/{{ $cat->slug }}</small>
            <div>
                <h3 class="fw-bold mb-0 d-inline me-1" style="font-size: 1.8rem;">{{ $cat->achievements_count ?? 0 }}</h3>
                <small class="text-muted fw-semibold" style="font-size: 0.8rem;">prestasi</small>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="bg-white p-4 rounded-4 text-center text-muted border">Belum ada kategori.</div>
    </div>
    @endforelse
</div>

@endsection

@section('modals')
<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nama Kategori</label>
                        <input type="text" name="name" class="form-control rounded-pill px-3" placeholder="Contoh: Riset & Inovasi" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold text-secondary">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control rounded-4 p-3" rows="3" placeholder="Deskripsi singkat kategori..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4 fw-semibold" style="background: linear-gradient(90deg, #f59e0b, #d97706); border:none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
