@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <!-- Menggunakan col-xl-10 agar lebih lebar di laptop/desktop -->
        <div class="col-12 col-lg-11 col-xl-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">

                    <!-- BAGIAN KIRI: Foto Profil & Visual (Sidebar) -->
                    <!-- Di Mobile urutan di atas, di Laptop di sebelah kiri -->
                    <div class="col-lg-4 bg-primary text-white d-flex flex-column align-items-center justify-content-center p-5 position-relative">
                        <!-- Dekorasi Background (Opsional untuk estetika) -->
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(0,0,0,0.1) 100%); pointer-events: none;"></div>

                        <div class="position-relative z-1 text-center">
                            <h4 class="fw-bold mb-4"><i class="fas fa-user-edit me-2"></i> Edit Profil</h4>

                            <!-- Wrapper Foto dengan Border Putih Tebal -->
                            <div class="position-relative d-inline-block mb-3">
                                <img id="avatarPreview"
                                    src="{{ $user->avatar_url }}"
                                    class="rounded-circle shadow bg-white"
                                    style="width: 160px; height: 160px; object-fit: cover; border: 4px solid rgba(255,255,255,0.8); cursor: pointer;"
                                    onclick="document.getElementById('avatarInput').click()"
                                    alt="Foto Profil">

                                <!-- Tombol Kamera Floating -->
                                <div class="position-absolute bottom-0 end-0 bg-white text-primary p-2 rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px; cursor: pointer; transition: transform 0.2s;"
                                    onclick="document.getElementById('avatarInput').click()"
                                    onmouseover="this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <i class="fas fa-camera fa-sm"></i>
                                </div>
                            </div>

                            <p class="small text-white-50 mb-0">Klik foto untuk mengganti</p>
                            <p class="small text-white-50">(Maksimal 2MB)</p>
                        </div>
                    </div>

                    <!-- BAGIAN KANAN: Form Input -->
                    <div class="col-lg-8 bg-white p-4 p-md-5">
                        <div class="mb-4 d-none d-lg-block">
                            <h5 class="fw-bold text-dark">Informasi Pengguna</h5>
                            <hr class="mt-2 mb-0" style="width: 50px; height: 3px; background-color: var(--bs-primary); opacity: 1;">
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Input File Hidden (Dipindahkan ke sini agar struktur form valid) -->
                            <input type="file" class="d-none @error('avatar') is-invalid @enderror"
                                id="avatarInput" name="avatar" accept="image/*" onchange="previewImage(event)">
                            @error('avatar') <div class="text-danger small mb-3">{{ $message }}</div> @enderror

                            <!-- Row untuk Nama & Email (Sejajar di Laptop) -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-bold text-secondary small text-uppercase">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                        <input type="text" class="form-control bg-light border-start-0 ps-0 py-2 @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama Anda" required>
                                    </div>
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold text-secondary small text-uppercase">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" class="form-control bg-light border-start-0 ps-0 py-2 @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="nama@email.com" required>
                                    </div>
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Input Alamat -->
                            <div class="mb-4">
                                <label for="address" class="form-label fw-bold text-secondary small text-uppercase">Alamat Domisili</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 align-items-start pt-2"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                    <textarea class="form-control bg-light border-start-0 ps-0 py-2 @error('address') is-invalid @enderror"
                                        id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                                </div>
                                @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2 align-items-center mt-5">
                                <a href="{{ route('profile.show') }}" class="btn btn-link text-decoration-none text-secondary fw-bold px-4">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm hover-scale">
                                    <i class="fas fa-save me-2"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahan CSS Sedikit untuk efek hover -->
<style>
    .hover-scale {
        transition: transform 0.2s;
    }

    .hover-scale:hover {
        transform: scale(1.02);
    }

    /* Memastikan input focus ring sesuai warna tema */
    .form-control:focus,
    .form-select:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.15);
    }

    .input-group-text {
        border-color: #dee2e6;
    }

    .form-control {
        border-color: #dee2e6;
    }
</style>

<!-- Script Javascript -->
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('avatarPreview');
            output.src = reader.result;
        };
        // Cek jika file dipilih
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection