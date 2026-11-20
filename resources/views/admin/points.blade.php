@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0" style="font-family:'Playfair Display', serif;">Aturan Poin</h3>
        <p class="text-muted small mb-0">Poin dihitung otomatis dari tingkat kompetisi dan hasil capaian</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 mb-3">{{ session('success') }}</div>
@endif

<div class="row g-3">
    @php
        $levels = [
            ['name' => 'Internasional', 'p' => [100, 85, 70, 30]],
            ['name' => 'Nasional', 'p' => [80, 65, 50, 20]],
            ['name' => 'Provinsi', 'p' => [60, 45, 35, 15]],
            ['name' => 'Kabupaten/Kota', 'p' => [40, 30, 20, 10]],
            ['name' => 'Sekolah', 'p' => [20, 15, 10, 5]],
        ];
    @endphp
    @foreach($levels as $lvl)
    <div class="col-md-4">
        <div class="bg-white p-4 rounded-4 border shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">{{ $lvl['name'] }}</h6>
                <span class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1" style="font-size: 0.65rem;">Resmi</span>
            </div>
            <div class="d-flex justify-content-between align-items-center p-2 rounded-3 bg-light mb-1.5"><small class="text-muted">Juara 1</small><span class="fw-bold text-dark">+{{ $lvl['p'][0] }} Poin</span></div>
            <div class="d-flex justify-content-between align-items-center p-2 rounded-3 bg-light mb-1.5"><small class="text-muted">Juara 2</small><span class="fw-bold text-dark">+{{ $lvl['p'][1] }} Poin</span></div>
            <div class="d-flex justify-content-between align-items-center p-2 rounded-3 bg-light mb-1.5"><small class="text-muted">Juara 3</small><span class="fw-bold text-dark">+{{ $lvl['p'][2] }} Poin</span></div>
            <div class="d-flex justify-content-between align-items-center p-2 rounded-3 bg-light"><small class="text-muted">Peserta/Finalis</small><span class="fw-bold text-dark">+{{ $lvl['p'][3] }} Poin</span></div>
        </div>
    </div>
    @endforeach
</div>
@endsection
