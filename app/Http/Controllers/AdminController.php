<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\User;
use App\Models\Category;
use App\Models\PointRule;
use App\Models\ActivityLog;
use App\Helpers\PointCalculator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Middleware;

class AdminController extends Controller
{

    // ==================== DASHBOARD ADMIN ====================
    public function dashboard()
    {
        // Proteksi ganda untuk role siswa
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Pengguna dengan peran siswa tidak memiliki izin akses ke dashboard admin.');
        }

        $pendingCount = Achievement::where('verification_status', 'pending')->count();
        $totalAchievements = Achievement::count();
        $totalStudents = User::whereIn('role', ['student', 'siswa'])->count();
        $achievements = Achievement::with('user')->latest()->get();

        return view('admin.dashboard', compact(
            'pendingCount',
            'totalAchievements',
            'totalStudents',
            'achievements'
        ));
    }

    // ==================== VERIFIKASI PRESTASI ====================
    public function verifications(Request $request)
    {
        $status = $request->query('status', 'pending');

        $pendingCount = Achievement::where('verification_status', 'pending')->count();
        $approvedCount = Achievement::where('verification_status', 'approved')->count();
        $rejectedCount = Achievement::where('verification_status', 'rejected')->count();

        $query = Achievement::with('user');
        if (in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('verification_status', $status);
        }

        $verificationsList = $query->latest()->get();

        return view('admin.verifications', compact(
            'verificationsList',
            'status',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    // ==================== SETUJUI / TOLAK PRESTASI ====================
    public function verify(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string',
        ]);

        $achievement = Achievement::with('user')->findOrFail($id);
        $achievement->verification_status = $request->status;

        if ($request->status === 'rejected') {
            $achievement->rejection_reason = $request->rejection_reason;
            $achievement->points = 0;
        } else {
            if (!$achievement->points) {
                $achievement->points = PointCalculator::calculate($achievement->level, $achievement->result);
            }
        }

        $achievement->save();

        // Catat aktivitas
        $studentName = $achievement->user ? $achievement->user->name : 'Siswa';
        $statusText = $request->status === 'approved' ? 'Menyetujui' : 'Menolak';
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => "{$statusText} pengajuan prestasi '{$achievement->title}' milik {$studentName}",
        ]);

        return back()->with('success', "Prestasi berhasil di-{$request->status}.");
    }

    // ==================== HAPUS USER BERDASARKAN USERNAME ====================
    public function destroyUserByUsername(string $username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return back()->with('error', "Pengguna dengan username '{$username}' tidak ditemukan.");
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;

        // Bersihkan foto profil dari storage
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Bersihkan sertifikat bukti prestasi dari storage
        foreach ($user->achievements as $achievement) {
            if ($achievement->evidence_path && Storage::disk('public')->exists($achievement->evidence_path)) {
                Storage::disk('public')->delete($achievement->evidence_path);
            }
        }

        // Hapus dari database (cascade delete achievements)
        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => "Menghapus akun pengguna '{$userName}' (username: {$username}) dari database",
        ]);

        return back()->with('success', "Pengguna '{$userName}' (username: {$username}) berhasil dihapus dari database.");
    }

    // ==================== KELOLA KATEGORI ====================
    public function categories()
    {
        $categoriesList = Category::withCount('achievements')->get();

        return view('admin.categories', compact('categoriesList'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => true,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => "Menambahkan kategori baru: '{$category->name}'",
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function destroyCategory(int $id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => "Menghapus kategori: '{$name}'",
        ]);

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // ==================== ATURAN POIN ====================
    public function points()
    {
        $rules = PointRule::all();
        return view('admin.points', compact('rules'));
    }

    public function updatePoints(Request $request)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => "Memperbarui aturan poin sistem",
        ]);

        return back()->with('success', 'Aturan poin berhasil diperbarui.');
    }

    // ==================== PENGATURAN ====================
    public function settings()
    {
        $schoolName = session('settings_school_name', 'SMK Metland Cibitung');
        $academicYear = session('settings_academic_year', '2026/2027');
        $schoolDesc = session('settings_school_desc', 'Portofolio prestasi resmi siswa SMK Metland Cibitung.');

        return view('admin.settings', compact('schoolName', 'academicYear', 'schoolDesc'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'school_name' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:50',
            'school_desc' => 'nullable|string',
        ]);

        session([
            'settings_school_name' => $request->school_name,
            'settings_academic_year' => $request->academic_year,
            'settings_school_desc' => $request->school_desc,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => "Memperbarui pengaturan sistem sekolah",
        ]);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    // ==================== LOG AKTIVITAS ====================
    public function logs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);

        return view('admin.logs', compact('logs'));
    }
}
