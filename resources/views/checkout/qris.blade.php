@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-4" style="background-color: #eef2f7;">

    <div class="container">
        <div class="row justify-content-center">
            <!-- Ukuran card dijaga agar mirip struk belanja/layar HP -->
            <div class="col-12 col-md-6 col-lg-4">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    <!-- HEADER: LOGO & NAMA TOKO (SEBARIS/HORIZONTAL) -->
                    <!-- Ini menghemat ruang vertikal -->
                    <div class="card-header bg-white border-0 pt-3 px-3 pb-0">
                        <div class="d-flex align-items-center">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                <img src="{{ asset('images/logo.jpg') }}"
                                    alt="Logo"
                                    class="rounded-circle border border-2 shadow-sm"
                                    style="width: 55px; height: 55px; object-fit: cover;">
                            </div>
                            <!-- Nama Toko & Info -->
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold text-dark mb-0">Delshoop</h6>
                                <div class="d-flex align-items-center mt-1">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1200px-Logo_QRIS.svg.png"
                                        alt="QRIS" style="height: 18px;" class="me-2">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-0" style="font-size: 0.65rem;">
                                        ID: 213234567890
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BODY: HARGA & QR CODE -->
                    <div class="card-body p-3 text-center">

                        <!-- Total Tagihan -->
                        <div class="mb-3">
                            <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Total Pembayaran</span>
                            <h3 class="fw-extra-bold text-dark mb-0">Rp {{ number_format($total_bayar, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Garis Putus-putus Pemisah -->
                        <div class="border-top border-2 border-dashed my-3 mx-4"></div>

                        <!-- Area Scan QR (Ukuran disesuaikan agar tidak terlalu panjang) -->
                        <div class="position-relative d-inline-block">
                            <div class="p-2 bg-white rounded border border-2 shadow-sm">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=BayarRp{{$total_bayar}}"
                                    alt="Scan QRIS"
                                    class="img-fluid rounded"
                                    style="width: 190px; height: 190px;"> <!-- Ukuran fix 190px -->
                            </div>
                            <!-- Scan Line Animation -->
                            <div class="scan-line"></div>
                        </div>

                        <p class="small text-muted mt-2 mb-3" style="font-size: 0.8rem;">
                            Scan dengan Qris
                        </p>

                        <!-- Tombol Aksi -->
                        <form action="{{ route('checkout.confirm') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill shadow-sm py-2 mb-2">
                                <i class="fas fa-check-circle me-1"></i> Saya Sudah Bayar
                            </button>
                        </form>

                        <a href="{{ route('user.dashboard') }}" class="text-decoration-none text-muted small fw-bold">
                            Batalkan
                        </a>
                    </div>

                    <!-- Footer Hiasan (Tipis) -->
                    <div class="card-footer bg-light py-2 text-center border-top-0">
                        <small class="text-muted" style="font-size: 0.7rem;">
                            <i class="fas fa-shield-alt me-1"></i> Transaksi Aman & Terenkripsi
                        </small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Tambahan */
    .fw-extra-bold {
        font-weight: 800;
    }

    .border-dashed {
        border-style: dashed !important;
        border-color: #e0e0e0 !important;
    }

    /* Animasi Scan Line (Disesuaikan posisinya) */
    .scan-line {
        position: absolute;
        width: 100%;
        height: 2px;
        background: rgba(255, 0, 0, 0.6);
        box-shadow: 0 0 4px red;
        top: 10px;
        left: 0;
        animation: scan 2s infinite linear;
    }

    @keyframes scan {
        0% {
            top: 10px;
            opacity: 0;
        }

        20% {
            opacity: 1;
        }

        80% {
            opacity: 1;
        }

        100% {
            top: 190px;
            opacity: 0;
        }
    }
</style>
@endsection