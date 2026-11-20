<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information and profile photo.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update nama
        $user->name = $request->validated('name');

        // Update email jika ada perubahan
        if ($request->has('email') && $request->validated('email') !== $user->email) {
            $user->email = $request->validated('email');
            $user->email_verified_at = null;
        }

        // Upload & simpan foto profil jika diunggah
        if ($request->hasFile('profile_photo')) {
            // Hapus foto profil lama jika ada
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto profil baru ke folder 'profile_photos' pada disk public
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('success', 'Profil dan foto profil berhasil diperbarui.');
    }

    /**
     * Delete the user's account safely.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus foto profil jika ada
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Hapus akun pengguna berdasarkan username (Database Deletion).
     */
    public function destroyByUsername(string $username): RedirectResponse
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return back()->with('error', "Pengguna dengan username '{$username}' tidak ditemukan.");
        }

        // Jika user yang login menghapus akunnya sendiri
        $isSelf = auth()->check() && auth()->id() === $user->id;

        // Hapus file fisik
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        foreach ($user->achievements as $achievement) {
            if ($achievement->evidence_path && Storage::disk('public')->exists($achievement->evidence_path)) {
                Storage::disk('public')->delete($achievement->evidence_path);
            }
        }

        $user->delete();

        if ($isSelf) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return Redirect::to('/')->with('success', 'Akun Anda berhasil dihapus.');
        }

        return back()->with('success', "Pengguna '{$username}' berhasil dihapus dari database.");
    }
}
