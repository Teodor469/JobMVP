<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\CVForm;
use App\Models\User;

class CVFormPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, CVForm $cvForm): bool|Response
    {
        return $user->id == $cvForm->user_id
            ? Response::allow()
            : Response::deny('You are not authorized to view this CV.');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, CVForm $cvForm): bool|Response
    {
        return $user->id == $cvForm->user_id
            ? Response::allow()
            : Response::deny('You are not authorized to edit this CV.');
    }

    public function delete(User $user, CVForm $cvForm): bool|Response
    {
        return $user->id == $cvForm->user_id
            ? Response::allow()
            : Response::deny('You are not authorized to delete this CV.');
    }

    public function restore(User $user, CVForm $cvForm): bool
    {
        return false;
    }

    public function forceDelete(User $user, CVForm $cvForm): bool
    {
        return false;
    }
}
