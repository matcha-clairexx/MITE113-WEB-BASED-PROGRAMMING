<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Lesson4AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_student_routes(): void
    {
        $student = $this->createStudent(User::factory()->create());

        $this->get(route('students.index'))->assertRedirect(route('login'));
        $this->get(route('students.show', $student))->assertRedirect(route('login'));
        $this->get(route('students.edit', $student))->assertRedirect(route('login'));
    }

    public function test_user_can_login_and_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_owner_can_view_edit_update_and_delete_student(): void
    {
        $owner = User::factory()->create();
        $student = $this->createStudent($owner);

        $this->actingAs($owner)
            ->get(route('students.show', $student))
            ->assertOk();

        $this->get(route('students.edit', $student))->assertOk();

        $this->put(route('students.update', $student), [
            'name' => 'Updated Student',
            'email' => 'updated@example.com',
            'program' => 'BSCS',
            'year' => 4,
            'id_number' => 'TEST-002',
        ])->assertRedirect(route('students.index'));

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Updated Student',
        ]);

        $this->delete(route('students.destroy', $student))
            ->assertRedirect(route('students.index'));

        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_non_owner_cannot_edit_update_or_delete_student(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $student = $this->createStudent($owner);

        $this->actingAs($otherUser)
            ->get(route('students.edit', $student))
            ->assertForbidden();

        $this->put(route('students.update', $student), [
            'name' => 'Unauthorized Change',
            'email' => 'changed@example.com',
            'program' => 'BSCS',
            'year' => 4,
            'id_number' => 'TEST-002',
        ])->assertForbidden();

        $this->delete(route('students.destroy', $student))->assertForbidden();

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Student One',
        ]);
    }

    public function test_non_owner_does_not_see_edit_or_delete_actions(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $student = $this->createStudent($owner);

        $this->actingAs($otherUser)
            ->get(route('students.index'))
            ->assertOk()
            ->assertDontSee(route('students.edit', $student))
            ->assertDontSee('name="_method" value="DELETE"');

        $this->get(route('students.show', $student))
            ->assertOk()
            ->assertDontSee(route('students.edit', $student))
            ->assertDontSee('name="_method" value="DELETE"');
    }

    public function test_admin_can_update_any_student(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $student = $this->createStudent($owner);

        $this->actingAs($admin)
            ->get(route('students.edit', $student))
            ->assertOk();
    }

    private function createStudent(User $owner): Student
    {
        return Student::create([
            'name' => 'Student One',
            'email' => 'student@example.com',
            'program' => 'BSIT',
            'year' => 3,
            'id_number' => 'TEST-001',
            'owner_id' => $owner->id,
        ]);
    }
}
