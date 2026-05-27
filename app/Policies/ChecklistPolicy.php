<?php

namespace App\Policies;

use App\Models\Checklist;
use App\Models\User;

class ChecklistPolicy
{
    public function view(User $user, Checklist $checklist): bool
    {
        return $user->id === $checklist->user_id;
    }

    public function update(User $user, Checklist $checklist): bool
    {
        return $user->id === $checklist->user_id;
    }

    public function delete(User $user, Checklist $checklist): bool
    {
        return $user->id === $checklist->user_id || $user->isAdmin();
    }
}
