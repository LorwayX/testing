@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Aturan Poin</h3>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Poin dihitung dari tingkat + hasil pencapaian</p>
    </div>
</div>

<div class="row g-4">
    <!-- Card Tingkat: Internasional -->
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border border-light">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Internasional</h6>
                <button class="btn btn-sm btn-light rounded-circle"><i class="bi bi-pencil"></i></button>
            </div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 1</span><strong>100</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 2</span><strong>90</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 3</span><strong>80</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Peserta/Finalis</span><strong>30</strong></div>
            </div>
        </div>
    </div>

    <!-- Card Tingkat: Nasional -->
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border border-light">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Nasional</h6>
                <button class="btn btn-sm btn-light rounded-circle"><i class="bi bi-pencil"></i></button>
            </div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 1</span><strong>80</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 2</span><strong>65</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 3</span><strong>50</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Peserta/Finalis</span><strong>20</strong></div>
            </div>
        </div>
    </div>

    <!-- Card Tingkat: Provinsi -->
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 shadow-sm border border-light">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Provinsi</h6>
                <button class="btn btn-sm btn-light rounded-circle"><i class="bi bi-pencil"></i></button>
            </div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 1</span><strong>80</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 2</span><strong>50</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Juara 3</span><strong>40</strong></div>
                <div class="d-flex justify-content-between p-2 bg-light rounded-3 small"><span>Peserta/Finalis</span><strong>15</strong></div>
            </div>
        </div>
    </div>
</div>
@endsection