<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Achievement;
use App\Models\Category;
use App\Models\PointRule;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchievoTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Sekolah',
            'username' => 'admin',
            'email' => 'admin@achievo.test',
            'role' => 'admin',
        ]);

        $this->student = User::factory()->create([
            'name' => 'Ashley Siburian',
            'username' => 'ashley',
            'email' => 'ashley@achievo.test',
            'role' => 'student',
            'class_name' => 'XI PPLG',
            'student_number' => '1234561',
        ]);

        Category::create([
            'name' => 'Teknologi',
            'slug' => 'teknologi',
            'is_active' => true,
        ]);

        PointRule::create([
            'level' => 'Nasional',
            'result' => 'Juara 1',
            'points' => 80,
            'is_active' => true,
        ]);
    }

    public function test_landing_page_renders(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Achievo');
    }

    public function test_student_dashboard_displays_stats(): void
    {
        Achievement::create([
            'user_id' => $this->student->id,
            'title' => 'Juara 1 Web Design',
            'category' => 'Teknologi',
            'organizer' => 'Kemdikbud',
            'level' => 'Nasional',
            'result' => 'Juara 1',
            'achievement_date' => '2026-04-01',
            'verification_status' => 'approved',
            'points' => 80,
        ]);

        $response = $this->actingAs($this->student)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Siswa');
        $response->assertSee('Juara 1 Web Design');
        $response->assertSee('80');
    }

    public function test_student_can_create_achievement(): void
    {
        $response = $this->actingAs($this->student)->post('/achievements', [
            'title' => 'Juara 1 AI Competition',
            'category' => 'Teknologi',
            'level' => 'Nasional',
            'result' => 'Juara 1',
            'date' => '2026-05-01',
            'organizer' => 'Universitas Indonesia',
            'description' => 'Lomba kecerdasan buatan tingkat nasional',
        ]);

        $response->assertRedirect(route('achievements.index'));
        $this->assertDatabaseHas('achievements', [
            'title' => 'Juara 1 AI Competition',
            'user_id' => $this->student->id,
            'points' => 80,
            'verification_status' => 'pending',
        ]);
    }

    public function test_student_can_delete_own_achievement(): void
    {
        $achievement = Achievement::create([
            'user_id' => $this->student->id,
            'title' => 'Lomba Desain Grafis',
            'category' => 'Teknologi',
            'organizer' => 'Sekolah',
            'level' => 'Sekolah',
            'result' => 'Juara 1',
            'achievement_date' => '2026-01-01',
            'points' => 20,
        ]);

        $response = $this->actingAs($this->student)->delete("/achievements/{$achievement->id}");
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('achievements', ['id' => $achievement->id]);
    }

    public function test_student_cannot_delete_other_student_achievement(): void
    {
        $otherStudent = User::factory()->create(['role' => 'student']);
        $achievement = Achievement::create([
            'user_id' => $otherStudent->id,
            'title' => 'Lomba Lain',
            'category' => 'Teknologi',
            'organizer' => 'Sekolah',
            'level' => 'Sekolah',
            'result' => 'Juara 1',
            'achievement_date' => '2026-01-01',
            'points' => 20,
        ]);

        $response = $this->actingAs($this->student)->delete("/achievements/{$achievement->id}");
        $response->assertStatus(403);
        $this->assertDatabaseHas('achievements', ['id' => $achievement->id]);
    }

    public function test_ranking_page_displays_leaderboard(): void
    {
        Achievement::create([
            'user_id' => $this->student->id,
            'title' => 'Prestasi Terverifikasi',
            'category' => 'Teknologi',
            'organizer' => 'Kemdikbud',
            'level' => 'Nasional',
            'result' => 'Juara 1',
            'achievement_date' => '2026-03-01',
            'verification_status' => 'approved',
            'points' => 80,
        ]);

        $response = $this->actingAs($this->student)->get('/ranking');
        $response->assertStatus(200);
        $response->assertSee('Ashley Siburian');
        $response->assertSee('80');
    }

    public function test_public_profile_page(): void
    {
        $response = $this->actingAs($this->student)->get("/u/{$this->student->username}");
        $response->assertStatus(200);
        $response->assertSee($this->student->name);
        $response->assertSee('XI PPLG');
    }

    public function test_student_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->student)->get('/admin/dashboard');
        $response->assertRedirect(route('dashboard'));
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Administrator');
    }

    public function test_admin_can_verify_achievement(): void
    {
        $achievement = Achievement::create([
            'user_id' => $this->student->id,
            'title' => 'Prestasi Baru',
            'category' => 'Teknologi',
            'organizer' => 'Kominfo',
            'level' => 'Nasional',
            'result' => 'Juara 1',
            'achievement_date' => '2026-04-01',
            'verification_status' => 'pending',
            'points' => 80,
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/verifications/{$achievement->id}", [
            'status' => 'approved',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('achievements', [
            'id' => $achievement->id,
            'verification_status' => 'approved',
        ]);
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->admin->id,
        ]);
    }

    public function test_admin_can_add_and_delete_category(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/categories', [
            'name' => 'Robotik Modern',
            'description' => 'Kategori robotika modern',
        ]);

        $response->assertSessionHas('success');
        $category = Category::where('name', 'Robotik Modern')->first();
        $this->assertNotNull($category);

        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/categories/{$category->id}");
        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_role_switcher_redirects(): void
    {
        $response = $this->actingAs($this->student)->get('/switch-role/admin');
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals('admin', $this->student->fresh()->role);

        $response2 = $this->actingAs($this->student)->get('/switch-role/student');
        $response2->assertRedirect(route('dashboard'));
        $this->assertEquals('student', $this->student->fresh()->role);
    }
}
