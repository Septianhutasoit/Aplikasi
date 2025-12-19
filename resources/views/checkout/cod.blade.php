@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-4" style="background-color: #eef2f7;">

    <div class="container">
        <div class="row justify-content-center">
            <!-- Ukuran card dijaga agar konsisten dengan halaman QRIS -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative">

                    <!-- Hiasan Atas (Status Bar like) -->
                    <div class="position-absolute top-0 start-0 w-100 bg-warning" style="height: 6px;"></div>

                    <!-- HEADER -->
                    <div class="card-header bg-white border-0 pt-4 px-3 pb-0">
                        <div class="d-flex align-items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/logo.jpg') }}"
                                    alt="Logo"
                                    class="rounded-circle border border-2 shadow-sm"
                                    style="width: 55px; height: 55px; object-fit: cover;">
                            </div>
                            <!-- Nama Toko & Status COD -->
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold text-dark mb-0">Delshoop</h6>
                                <div class="d-flex align-items-center mt-1">
                                    <i class="fas fa-motorcycle text-warning me-2"></i>
                                    <span class="badge bg-warning bg-opacity-25 text-dark border border-warning px-2 py-0" style="font-size: 0.65rem;">
                                        METODE: COD (BAYAR DITEMPAT)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BODY -->
                    <div class="card-body p-3 text-center">

                        <!-- Total Tagihan -->
                        <div class="mb-3 mt-2">
                            <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Siapkan Uang Sejumlah</span>
                            <h3 class="fw-extra-bold text-dark mb-0">Rp {{ number_format($total_bayar, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Garis Putus-putus -->
                        <div class="border-top border-2 border-dashed my-3 mx-4"></div>

                        <!-- Ilustrasi COD -->
                        <div class="my-4 position-relative">
                            <div class="cod-icon-wrapper d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10 mb-2"
                                style="width: 100px; height: 100px;">
                                <i class="fas fa-handshake text-warning" style="font-size: 3.5rem;"></i>
                            </div>
                            <div class="pulse-ring"></div>
                        </div>

                        <!-- Detail Jadwal COD (Penting) -->
                        <div class="bg-light rounded-3 p-3 text-start border border-light shadow-sm">
                            <h6 class="fw-bold text-dark mb-3 small border-bottom pb-2">Jadwal Pertemuan</h6>

                            <!-- Jam -->
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-3 text-center" style="width: 25px;">
                                    <i class="fas fa-clock text-primary fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Waktu COD</small>
                                    <!-- Mengambil data dari variabel yang dikirim controller -->
                                    <strong class="text-dark">{{ $waktu_cod ?? '00:00' }} WIB</strong>
                                </div>
                            </div>

                            <!-- Catatan / Lokasi -->
                            <div class="d-flex align-items-start">
                                <div class="me-3 text-center" style="width: 25px;">
                                    <i class="fas fa-map-marker-alt text-danger fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Lokasi / Catatan</small>
                                    <span class="text-dark fw-bold small" style="line-height: 1.2;">
                                        {{ $catatan_cod ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Pesan Instruksi -->
                        <div class="alert alert-warning border-0 d-flex align-items-center p-2 mt-3 mb-0 rounded-3" role="alert">
                            <i class="fas fa-info-circle fs-4 me-2"></i>
                            <div class="text-start small" style="line-height: 1.1; font-size: 0.75rem;">
                                Mohon tunggu di lokasi pada jam tersebut dan siapkan uang pas.
                            </div>
                        </div>

                    </div>

                    <!-- Footer: Tombol -->
                    <div class="card-footer bg-white p-3 border-0">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-dark w-100 fw-bold rounded-pill shadow-sm py-2 mb-2">
                            <i class="fas fa-home me-1"></i> Kembali ke Beranda
                        </a>
                        <a href="https://wa.me/6281234567890?text=Halo admin, saya sudah pesan COD..."
                            target="_blank"
                            class="btn btn-outline-success w-100 fw-bold rounded-pill border-2 py-1" style="font-size: 0.85rem;">
                            <i class="fab fa-whatsapp me-1"></i> Hubungi Penjual
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-extra-bold {
        font-weight: 800;
    }

    .border-dashed {
        border-style: dashed !important;
        border-color: #e0e0e0 !important;
    }

    /* Efek Pulse untuk Ikon Tangan */
    .cod-icon-wrapper {
        position: relative;
        z-index: 2;
        animation: float 3s ease-in-out infinite;
    }

    .pulse-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100px;
        height: 100px;
        background: rgba(255, 193, 7, 0.4);
        border-radius: 50%;
        z-index: 1;
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        100% {
            transform: translate(-50%, -50%) scale(1.6);
            opacity: 0;
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }

        100% {
            transform: translateY(0px);
        }
    }
</style>
@endsection