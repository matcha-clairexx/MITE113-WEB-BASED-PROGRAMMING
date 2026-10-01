<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Lesson4AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/students')->assertRedirect('/login');
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_owner_can_update_student(): void
    {
        $user = User::factory()->create();
        $student = Student::create([
            'name' => 'Student One',
            'email' => 'student@example.com',
            'program' => 'BSIT',
            'year' => 3,
            'id_number' => 'TEST-001',
            'owner_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('students.edit', $student))
            ->assertOk();
    }

    public function test_non_owner_gets_forbidden(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $student = Student::create([
            'name' => 'Student One',
            'email' => 'student@example.com',
            'program' => 'BSIT',
            'year' => 3,
            'id_number' => 'TEST-001',
            'owner_id' => $owner->id,
        ]);

        $this->actingAs($otherUser)
            ->get(route('students.edit', $student))
            ->assertForbidden();
    }

    public function test_admin_can_update_any_student(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);

        $student = Student::create([
            'name' => 'Student One',
            'email' => 'student@example.com',
            'program' => 'BSIT',
            'year' => 3,
            'id_number' => 'TEST-001',
            'owner_id' => $owner->id,
        ]);

        $this->actingAs($admin)
            ->get(route('students.edit', $student))
            ->assertOk();
    }
}
