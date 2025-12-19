@extends('layouts.app')

@section('content')
<style>
    /* CSS Tambahan */
    .bg-gradient-soft {
        background: linear-gradient(135deg, #f6f8fd 0%, #eef2f8 100%);
        min-height: 85vh;
    }

    .card-modern {
        border: none;
        border-radius: 24px;
        /* Sudut lebih membulat karena kartu lebih lebar */
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .icon-box {
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25);
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .btn-gradient {
        background: linear-gradient(90deg, #0d6efd 0%, #0043a8 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        color: white;
    }
</style>

<div class="d-flex align-items-center bg-gradient-soft py-5">
    <div class="container">

        <!-- Header Navigasi -->
        <div class="row justify-content-center mb-3">
            <!-- UPDATE: Lebar kolom disesuaikan (col-lg-8) -->
            <div class="col-lg-8 col-md-10">
                <a href="{{ route('user.messages.index') }}" class="text-decoration-none text-muted fw-medium small hover-primary transition-all">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pesan
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <!-- UPDATE: Mengubah col-lg-6 menjadi col-lg-8 agar lebih lebar -->
            <div class="col-lg-8 col-md-10">

                <!-- CARD FORM -->
                <div class="card card-modern bg-white overflow-hidden">
                    <div class="card-body p-4 p-md-5">

                        <!-- Header Card -->
                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-4 pb-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <div class="icon-box me-4 flex-shrink-0">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold text-dark mb-1">Mulai Diskusi</h3>
                                    <p class="text-muted small mb-0">
                                        Punya pertanyaan produk atau kendala pesanan?
                                    </p>
                                </div>
                            </div>

                            <!-- Estimasi Waktu (Pindah ke kanan di layar besar) -->
                            <div class="ms-md-auto mt-3 mt-md-0 text-md-end">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                    <i class="fas fa-clock me-1"></i> Balasan ± 10 Menit
                                </span>
                            </div>
                        </div>

                        <!-- Form -->
                        <form action="{{ route('user.messages.store') }}" method="POST">
                            @csrf

                            <!-- Subject -->
                            <div class="form-floating mb-3">
                                <input type="text" name="subject" class="form-control rounded-3" id="subjectInput" placeholder="Topik" required>
                                <label for="subjectInput" class="text-muted"><i class="fas fa-heading me-1"></i> Topik / Judul Pesan</label>
                            </div>

                            <!-- Message -->
                            <div class="form-floating mb-4">
                                <!-- Tinggi textarea ditambah agar proporsional dengan lebar baru -->
                                <textarea name="message" class="form-control rounded-3" id="messageInput" style="height: 180px" placeholder="Pesan" required></textarea>
                                <label for="messageInput" class="text-muted"><i class="fas fa-pencil-alt me-1"></i> Jelaskan detail pertanyaan Anda di sini...</label>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-7 mb-3 mb-md-0">
                                    <!-- Info Tambahan -->
                                    <div class="d-flex text-muted small">
                                        <i class="fas fa-info-circle text-primary mt-1 me-2"></i>
                                        <span>Pastikan data yang Anda masukkan benar agar kami dapat merespons dengan cepat.</span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <!-- Button Submit -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-gradient btn-lg rounded-pill py-3 fw-bold fs-6">
                                            Kirim Pesan <i class="fas fa-paper-plane ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection