@extends('layouts.student')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="font-family:'Playfair Display', serif;">Tambah Prestasi</h3>
        <p class="text-muted small mb-0">Isi detail dan unggah bukti untuk diverifikasi oleh sekolah</p>
    </div>
    <a href="{{ route('achievements.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm border small fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

@if(session('error'))
    <div class="alert alert-danger rounded-4 mb-3">{{ session('error') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-3">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">
        <!-- Kolom Kiri: Form Utama -->
        <div class="col-lg-8">
            <div class="bg-white p-4 rounded-4 shadow-sm border">
                <div class="mb-3">
                    <label class="form-label small text-muted fw-semibold">Judul Prestasi</label>
                    <input type="text" name="title" class="form-control rounded-pill px-3 py-2.5" placeholder="Contoh: Juara 1 Lomba Web Development" value="{{ old('title') }}" required>
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">Kategori</label>
                        <select name="category" class="form-select rounded-pill px-3 py-2.5" required>
                            @php
                                $categoryOptions = ['Akademik', 'Teknologi', 'Olahraga', 'Seni & Kreativitas', 'Organisasi', 'Sosial & Lingkungan'];
                                if (isset($categories) && count($categories) > 0) {
                                    $categoryOptions = $categories->pluck('name')->toArray();
                                }
                            @endphp
                            @foreach($categoryOptions as $catOption)
                                <option value="{{ $catOption }}" {{ old('category') == $catOption ? 'selected' : '' }}>{{ $catOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">Tingkat</label>
                        <select name="level" class="form-select rounded-pill px-3 py-2.5" required>
                            <option value="Internasional" {{ old('level') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            <option value="Nasional" {{ old('level', 'Nasional') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="Provinsi" {{ old('level') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                            <option value="Kabupaten/Kota" {{ old('level') == 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                            <option value="Sekolah" {{ old('level') == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">Hasil</label>
                        <select name="result" class="form-select rounded-pill px-3 py-2.5" required>
                            <option value="Juara 1" {{ old('result', 'Juara 1') == 'Juara 1' ? 'selected' : '' }}>Juara 1</option>
                            <option value="Juara 2" {{ old('result') == 'Juara 2' ? 'selected' : '' }}>Juara 2</option>
                            <option value="Juara 3" {{ old('result') == 'Juara 3' ? 'selected' : '' }}>Juara 3</option>
                            <option value="Peserta/Finalis" {{ old('result') == 'Peserta/Finalis' ? 'selected' : '' }}>Peserta/Finalis</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted fw-semibold">Tanggal Pencapaian</label>
                        <input type="date" name="date" class="form-control rounded-pill px-3 py-2.5" value="{{ old('date', date('Y-m-d')) }}" required>  
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted fw-semibold">Penyelenggara</label>
                    <input type="text" name="organizer" class="form-control rounded-pill px-3 py-2.5" placeholder="Contoh: Dinas Pendidikan Jawa Barat" value="{{ old('organizer') }}">
                </div>

                <div class="mb-2">
                    <label class="form-label small text-muted fw-semibold">Deskripsi (opsional)</label>
                    <textarea name="description" class="form-control rounded-4 p-3" rows="3" placeholder="Ceritakan tentang prestasi dan pengalaman ini...">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Unggah Bukti & Visibilitas -->
        <div class="col-lg-4">
            <!-- Kotak Upload File -->
            <div class="bg-white p-4 rounded-4 shadow-sm border mb-4 text-center">
                <label class="form-label small text-muted fw-semibold d-block text-start mb-2">Bukti / Sertifikat</label>
                <div class="border border-dashed rounded-4 p-4 bg-light position-relative" style="border: 2px dashed #ddd; cursor: pointer;">
                    <input type="file" name="certificate" id="certFile" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" onchange="previewFileName(this)" required>
                    <i class="bi bi-cloud-arrow-up fs-1 text-warning mb-2 d-block"></i>
                    <span id="file-label" class="small fw-semibold d-block text-dark">Klik atau seret file ke sini</span>
                    <small class="text-muted" style="font-size: 0.65rem;">PDF, JPG, PNG - maks 5MB</small>
                </div>
            </div>

            <!-- Opsi Visibilitas -->
            <!-- <div class="bg-white p-4 rounded-4 shadow-sm border mb-4">
                <label class="form-label small text-muted fw-semibold mb-2">Visibilitas</label>
                <div class="d-flex flex-column gap-2">
                    <div class="p-2.5 rounded-3 bg-light border position-relative">
                        <div class="form-check m-0">
                            <input class="form-check-input" type="radio" name="visibility" id="visPublic" value="public" checked>
                            <label class="form-check-label fw-bold small ms-1" for="visPublic">Publik</label>
                        </div>
                        <small class="text-muted d-block ps-4" style="font-size: 0.65rem;">Siapa saja dapat melihat di profil</small>
                    </div>
                    <div class="p-2.5 rounded-3 bg-light border position-relative">
                        <div class="form-check m-0">
                            <input class="form-check-input" type="radio" name="visibility" id="visSchool" value="school">
                            <label class="form-check-label fw-bold small ms-1" for="visSchool">Warga Sekolah</label>
                        </div>
                        <small class="text-muted d-block ps-4" style="font-size: 0.65rem;">Hanya dapat dilihat akun sekolah</small>
                    </div>
                </div>
            </div> -->

            <!-- Tombol Aksi -->
            <div class="d-flex gap-2">
                <a href="{{ route('achievements.index') }}" class="btn btn-light rounded-pill w-50 py-2.5 fw-semibold border">Batal</a>
                <button type="submit" class="btn btn-warning text-white rounded-pill w-50 py-2.5 fw-semibold shadow-sm" style="background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); border:none;">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    function previewFileName(input) {
        if (input.files && input.files[0]) {
            document.getElementById('file-label').innerText = input.files[0].name;
        }
    }
</script>
@endsection
