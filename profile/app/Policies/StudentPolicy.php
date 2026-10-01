<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    /**
     * An owner or administrator may update a student.
     */
    public function update(User $user, Student $student): bool
    {
        return $user->is_admin || $user->id === $student->owner_id;
    }

    /**
     * An owner or administrator may delete a student.
     */
    public function delete(User $user, Student $student): bool
    {
        return $user->is_admin || $user->id === $student->owner_id;
    }
}
