<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\User;
use App\Models\Category;
use App\Helpers\PointCalculator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AchievoController extends Controller
{
    // ==================== LANDING / WELCOME ====================
    public function landing()
    {
        $topRanks = User::where('role', 'student')
            ->withSum([
                'achievements' => function ($q) {
                    $q->where('verification_status', 'approved');
                }
            ], 'points')
            ->orderByDesc('achievements_sum_points')
            ->take(5)
            ->get();

        $featuredCertificates = Achievement::with('user')
            ->where('verification_status', 'approved')
            ->whereNotNull('evidence_path')
            ->latest()
            ->take(4)
            ->get();

        return view('welcome', compact('topRanks', 'featuredCertificates'));
    }

    // ==================== DASHBOARD SISWA ====================
    public function dashboard()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $myAchievements = Achievement::where('user_id', $user->id)->latest('created_at')->get();
        $approvedMy = $myAchievements->where('verification_status', 'approved');

        $totalPoints = (int) $approvedMy->sum('points');
        $totalVerified = $approvedMy->count();
        $recentAchievements = $myAchievements->take(4);

        $pendingCount = Achievement::where('user_id', $user->id)->where('verification_status', 'pending')->count();

        // Hitung peringkat siswa
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

        return view('dashboard', compact(
            'totalPoints',
            'totalVerified',
            'myAchievements',
            'recentAchievements',
            'user',
            'pendingCount',
            'myRank'
        ));
    }

    // ==================== LIST PRESTASI ====================
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Achievement::where('user_id', $user->id);

        if ($request->filled('status') && in_array($request->status, ['approved', 'pending', 'rejected'])) {
            $query->where('verification_status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $achievements = $query->latest('created_at')->get();

        return view('achievements.index', compact('achievements'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('achievements.create', compact('categories'));
    }

    // ==================== SIMPAN PRESTASI KE DB ====================
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'level' => 'required|string|max:100',
            'result' => 'required|string|max:100',
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

        // Poin otomatis dihitung
        $points = PointCalculator::calculate($request->level, $request->result);

        $achievementDate = $request->date ?? $request->achievement_date ?? Carbon::now()->toDateString();
        $organizer = $request->organizer ?: 'Sekolah / Panitia Penyelenggara';

        // Simpan langsung ke database
        Achievement::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'category' => $request->category,
            'organizer' => $organizer,
            'level' => $request->level,
            'result' => $request->result,
            'achievement_date' => $achievementDate,
            'description' => $request->description,
            'evidence_path' => $path,
            'visibility' => $request->visibility ?? 'public',
            'verification_status' => 'pending',
            'points' => $points,
        ]);

        return redirect()->route('achievements.index')->with('success', 'Prestasi berhasil diajukan dan menunggu verifikasi.');
    }

    // ==================== HAPUS PRESTASI ====================
    public function destroy(int $id)
    {
        $achievement = Achievement::findOrFail($id);

        // Pastikan hanya pemilik atau admin yang bisa menghapus
        if ($achievement->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($achievement->evidence_path) {
            Storage::disk('public')->delete($achievement->evidence_path);
        }

        $achievement->delete();

        return back()->with('success', 'Prestasi berhasil dihapus dari database.');
    }

    // ==================== RANKING ====================
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

    // ==================== PROFIL PUBLIK ====================
    public function publicProfile(string $username)
    {
        $student = User::where('username', $username)
            ->orWhere('student_number', $username)
            ->orWhere('id', $username)
            ->first();

        if (!$student) {
            // Fallback ke authenticated user jika ada
            if (auth()->check()) {
                $student = auth()->user();
            } else {
                abort(404, 'Profil siswa tidak ditemukan.');
            }
        }

        $approvedAchievements = Achievement::where('user_id', $student->id)
            ->where('verification_status', 'approved')
            ->latest('achievement_date')
            ->get();

        $totalPoints = (int) $approvedAchievements->sum('points');
        $totalPrestasi = $approvedAchievements->count();

        // Peringkat keseluruhan
        $rankings = User::where('role', 'student')
            ->withSum([
                'achievements' => function ($q) {
                    $q->where('verification_status', 'approved');
                }
            ], 'points')
            ->orderByDesc('achievements_sum_points')
            ->get();

        $rankIndex = $rankings->search(fn($item) => $item->id === $student->id);
        $myRank = ($rankIndex !== false) ? ($rankIndex + 1) : 1;

        $userName = $student->name;
        $userClass = $student->class_name ?? 'XI PPLG';
        $userNis = $student->student_number ?? '-';

        $userAchievements = $approvedAchievements->map(function ($item) {
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

        return view('profiles.public', compact(
            'student',
            'userName',
            'userClass',
            'userNis',
            'totalPoints',
            'totalPrestasi',
            'myRank',
            'userAchievements'
        ));
    }

    // ==================== ROLE SWITCHER ====================
    public function switchRole(string $role)
    {
        if (!in_array($role, ['admin', 'student'])) {
            return redirect()->back();
        }

        $user = auth()->user();
        if ($user) {
            $user->update(['role' => $role]);
        }

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Beralih ke mode Admin.');
        }

        return redirect()->route('dashboard')->with('success', 'Beralih ke mode Siswa.');
    }
}
