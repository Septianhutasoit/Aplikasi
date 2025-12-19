@extends('layouts.app')

@section('content')
<style>
    /* --- CSS Custom untuk Halaman Profil --- */

    /* Sidebar Kiri (Foto & Menu) */
    .card-profile-sidebar {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        /* Shadow lembut */
    }

    /* Konten Kanan (Detail Info) */
    .card-profile-detail {
        border: none;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    /* Header Gradient di Sidebar */
    .sidebar-header {
        background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
        height: 140px;
        position: relative;
    }

    /* Wrapper Foto Profil */
    .avatar-container {
        margin-top: -75px;
        /* Membuat foto 'menembus' batas header */
        position: relative;
        display: inline-block;
    }

    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        background-color: #fff;
    }

    /* Styling Kotak Detail Data */
    .detail-item {
        padding: 20px;
        border-radius: 16px;
        background-color: #f8fafc;
        /* Background abu sangat muda */
        border: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .detail-item:hover {
        background-color: #fff;
        border-color: #e2e8f0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        /* Efek angkat saat hover */
        transform: translateY(-3px);
    }

    /* Ikon di sebelah kiri data */
    .detail-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    /* Tipografi Label & Value */
    .label-text {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .value-text {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.4;
    }

    /* Helper Hover */
    .hover-scale {
        transition: transform 0.2s;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }
</style>

<div class="container py-5">

    <!-- Breadcrumb Navigasi -->
    <nav aria-label="breadcrumb" class="mb-4 d-none d-lg-block">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Profile Saya</li>
        </ol>
    </nav>

    <!-- Alert Notifikasi -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4 border-0" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-lg me-2"></i>
            <strong>Berhasil!</strong> &nbsp; {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        <!-- ==========================
             KOLOM KIRI: SIDEBAR PROFIL
             ========================== -->
        <div class="col-lg-4">
            <div class="card card-profile-sidebar h-100">
                <div class="sidebar-header">
                    <!-- Hiasan Pattern Transparan -->
                    <div class="position-absolute top-0 end-0 p-3 opacity-25 text-white">
                        <i class="fas fa-circle-notch fa-2x fa-spin" style="animation-duration: 10s;"></i>
                    </div>
                </div>

                <div class="card-body text-center pt-0 pb-5 px-4">
                    <!-- Foto Profil -->
                    <div class="avatar-container mb-3">
                        <img src="{{ $user->avatar_url }}" class="rounded-circle profile-img" alt="Avatar">

                        <!-- Badge Role User -->
                        <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark text-white border border-2 border-white py-2 px-3 shadow-sm"
                            style="transform: translate(10%, 10%); font-size: 0.85rem;">
                            {{ ucfirst($user->role ?? 'User') }}
                        </span>
                    </div>

                    <!-- Nama User -->
                    <h3 class="fw-bold text-dark mb-1">{{ $user->name }}</h3>
                    <p class="text-muted small mb-4">
                        <i class="fas fa-clock me-1"></i> Bergabung {{ $user->created_at->diffForHumans() }}
                    </p>

                    <!-- Tombol Aksi Sidebar -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm hover-scale">
                            <i class="fas fa-pen-to-square me-2"></i> Edit Profil
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary rounded-pill py-2 fw-bold border-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==========================
             KOLOM KANAN: DETAIL DATA
             ========================== -->
        <div class="col-lg-8">
            <div class="card card-profile-detail h-100 p-4 p-lg-5">

                <!-- Header Section Kanan -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="fw-bold m-0 text-dark">
                        <span class="text-primary me-2"><i class="fas fa-address-card"></i></span> Informasi Pribadi
                    </h4>
                    <!-- Badge Status Akun -->
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-10">
                        <i class="fas fa-check-circle me-1"></i> Akun Aktif
                    </span>
                </div>

                <div class="row g-3">

                    <!-- 1. Email -->
                    <div class="col-md-6">
                        <div class="detail-item h-100 d-flex align-items-center">
                            <div class="detail-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="label-text">Alamat Email</div>
                                <div class="value-text text-truncate" title="{{ $user->email }}">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Tanggal Bergabung -->
                    <div class="col-md-6">
                        <div class="detail-item h-100 d-flex align-items-center">
                            <div class="detail-icon bg-info bg-opacity-10 text-info me-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <div class="label-text">Tanggal Registrasi</div>
                                <div class="value-text">{{ $user->created_at->isoFormat('D MMMM Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Alamat Domisili -->
                    <div class="col-12">
                        <div class="detail-item d-flex align-items-start">
                            <div class="detail-icon bg-warning bg-opacity-10 text-warning me-3 mt-1">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div>
                                <div class="label-text mb-1">Alamat Domisili</div>
                                <div class="value-text">
                                    @if($user->address)
                                    {{ $user->address }}
                                    @else
                                    <span class="text-muted fst-italic fw-normal small">
                                        <i class="fas fa-info-circle me-1"></i> Belum ada alamat yang ditambahkan.
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. MODIFIKASI: Status Update Profil (Pengganti Keamanan) -->
                    <div class="col-12">
                        <div class="detail-item d-flex align-items-center">
                            <!-- Icon History -->
                            <div class="detail-icon bg-secondary bg-opacity-10 text-secondary me-3">
                                <i class="fas fa-history"></i>
                            </div>

                            <!-- Teks Informasi Update -->
                            <div class="flex-grow-1">
                                <div class="label-text">Pembaruan Data Terakhir</div>
                                <div class="value-text fs-6">
                                    <span class="text-dark fw-bold">{{ $user->updated_at->diffForHumans() }}</span>
                                    <span class="text-muted small ms-1 fw-normal">({{ $user->updated_at->format('d/m/Y H:i') }})</span>
                                </div>
                            </div>

                            <!-- Badge Status Verifikasi (Hanya Tampil di Tablet/Desktop) -->
                            <div class="d-none d-sm-block ms-3 text-end">
                                <div class="label-text text-end mb-1" style="font-size: 0.65rem;">Status Profil</div>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                    <i class="fas fa-user-check text-success me-1"></i> Terverifikasi
                                </span>
                            </div>
                        </div>
                    </div>

                </div> <!-- End Row -->
            </div>
        </div>

    </div>
</div>
@endsection