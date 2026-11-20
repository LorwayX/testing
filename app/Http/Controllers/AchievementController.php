<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\User;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Helpers\PointCalculator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AchievementController extends Controller
{
    // Dashboard Siswa & Admin
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $achievements = Achievement::where('user_id', $user->id)->latest('created_at')->get();
        $approvedAchievements = $achievements->where('verification_status', 'approved');
        $totalPoints = (int) $approvedAchievements->sum('points');
        $totalVerified = $approvedAchievements->count();
        $recentAchievements = $achievements->take(4);

        $rankings = User::where('role', 'student')
            ->withSum([
                'achievements' => function ($q) {
                    $q->where('verification_status', 'approved');
                }
            ], 'points')
            ->orderByDesc('achievements_sum_points')
            ->get();

        $rankIndex = $rankings->search(fn($item) => $item->id === $user->id);
        $myRank = ($rankIndex !== false) ? ($rankIndex + 1) : 1;

        return view('dashboard', compact('totalPoints', 'totalVerified', 'recentAchievements', 'myRank', 'achievements'));
    }

    // Daftar Prestasi Saya
    public function index(Request $request)
    {
        $query = Achievement::where('user_id', Auth::id());

        if ($request->filled('status') && in_array($request->status, ['approved', 'pending', 'rejected'])) {
            $query->where('verification_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $achievements = $query->latest('created_at')->get();
        return view('achievements.index', compact('achievements'));
    }

    // Form Tambah Prestasi
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('achievements.create', compact('categories'));
    }

    // Simpan Prestasi Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'level' => 'required|string',
            'result' => 'required|string',
            'date' => 'nullable|date',
            'achievement_date' => 'nullable|date',
            'organizer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'evidence' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'visibility' => 'nullable|string|in:public,school,private',
        ]);

        $path = null;
        if ($request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('evidences', 'public');
        } elseif ($request->hasFile('evidence')) {
            $path = $request->file('evidence')->store('evidences', 'public');
        }

        $points = PointCalculator::calculate($request->level, $request->result);
        $achievementDate = $request->date ?? $request->achievement_date ?? Carbon::now()->toDateString();
        $organizer = $request->organizer ?: 'Sekolah / Panitia Penyelenggara';

        Achievement::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'level' => $request->level,
            'result' => $request->result,
            'achievement_date' => $achievementDate,
            'organizer' => $organizer,
            'description' => $request->description,
            'evidence_path' => $path,
            'visibility' => $request->visibility ?? 'public',
            'verification_status' => 'pending',
            'points' => $points,
        ]);

        return redirect()->route('achievements.index')->with('success', 'Prestasi berhasil diajukan dan menunggu verifikasi.');
    }

    // Hapus Prestasi
    public function destroy(int $id)
    {
        $achievement = Achievement::where('user_id', Auth::id())->findOrFail($id);
        if ($achievement->evidence_path) {
            Storage::disk('public')->delete($achievement->evidence_path);
        }
        $achievement->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }

    // Halaman Ranking
    public function ranking(Request $request)
    {
        $category = $request->query('category');

        $query = User::where('role', 'student')
            ->withSum([
                'achievements' => function ($q) use ($category) {
                    $q->where('verification_status', 'approved');
                    if ($category) {
                        $q->where('category', $category);
                    }
                }
            ], 'points')
            ->withCount([
                'achievements' => function ($q) use ($category) {
                    $q->where('verification_status', 'approved');
                    if ($category) {
                        $q->where('category', $category);
                    }
                }
            ]);

        $students = $query->orderByDesc('achievements_sum_points')->get();

        $leaderboard = $students->map(function ($s) {
            return [
                'id' => $s->id,
                'name' => $s->name,
                'username' => $s->username ?? $s->student_number ?? $s->id,
                'class' => $s->class_name ?? 'XI PPLG',
                'points' => (int) ($s->achievements_sum_points ?? 0),
                'achievements_count' => (int) ($s->achievements_count ?? 0),
            ];
        })->toArray();

        return view('ranking.index', compact('leaderboard', 'category'));
    }

    // Profil Saya
    public function profile()
    {
        $user = Auth::user();
        $achievements = Achievement::where('user_id', $user->id)->where('verification_status', 'approved')->get();
        $totalPoints = $achievements->sum('points');
        $totalPrestasi = $achievements->count();

        $rankings = User::where('role', 'student')
            ->withSum([
                'achievements' => function ($q) {
                    $q->where('verification_status', 'approved');
                }
            ], 'points')
            ->orderByDesc('achievements_sum_points')
            ->get();
        $rankIndex = $rankings->search(fn($item) => $item->id === $user->id);
        $myRank = ($rankIndex !== false) ? ($rankIndex + 1) : 1;

        $userName = $user->name;
        $userClass = $user->class_name ?? 'XI PPLG';
        $userNis = $user->student_number ?? '-';
        $student = $user;

        $userAchievements = $achievements->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'date' => $item->achievement_date ? Carbon::parse($item->achievement_date)->translatedFormat('d F Y') : '-',
                'level' => $item->level,
                'category' => $item->category,
                'points' => $item->points,
                'evidence_path' => $item->evidence_path,
            ];
        })->toArray();

        return view('profiles.public', compact('student', 'user', 'userName', 'userClass', 'userNis', 'userAchievements', 'totalPoints', 'totalPrestasi', 'myRank'));
    }

    // Panel Admin: Lihat Pengajuan Verifikasi
    public function accessVerifications()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $pending = Achievement::where('verification_status', 'pending')->with('user')->get();
        return view('admin.verifications', compact('pending'));
    }

    // Admin: Setujui / Tolak Prestasi
    public function verify(Request $request, int $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $achievement = Achievement::findOrFail($id);
        $achievement->verification_status = $request->status;
        if ($request->status === 'rejected') {
            $achievement->rejection_reason = $request->rejection_reason;
            $achievement->points = 0;
        } else {
            // Jika disetujui, pastikan poin dihitung
            if (!$achievement->points) {
                $achievement->points = PointCalculator::calculate($achievement->level, $achievement->result);
            }
        }
        $achievement->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => ($request->status === 'approved' ? 'Menyetujui' : 'Menolak') . " pengajuan prestasi: '{$achievement->title}'",
        ]);

        return back()->with('success', 'Status prestasi berhasil diperbarui.');
    }
}
