<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage; // Wajib import ini untuk hapus/upload file
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil (Tampilan Modern).
     */
    public function show(): View
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memproses update profil (Nama, Email, Alamat, Avatar).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 1. Ambil data yang sudah divalidasi dari Request
        $user = $request->user();
        $validatedData = $request->validated();

        // 2. Isi data dasar (Nama, Email)
        $user->fill($validatedData);

        // 3. Cek perubahan email untuk verifikasi ulang
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 4. Update Alamat (Pastikan 'address' ada di ProfileUpdateRequest atau handle manual)
        // Jika Anda belum update ProfileUpdateRequest, kita ambil manual dari request:
        if ($request->has('address')) {
            $user->address = $request->input('address');
        }

        // 5. Logika Upload Avatar
        if ($request->hasFile('avatar')) {
            // Validasi file gambar (opsional jika belum ada di Request)
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Hapus avatar lama jika ada (dan bukan null)
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Simpan avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 6. Simpan perubahan ke database
        $user->save();

        // Redirect ke halaman Show Profile dengan pesan sukses
        return Redirect::route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Hapus avatar user dari storage saat akun dihapus (opsional, agar bersih)
        if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
            Storage::delete('public/' . $user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
