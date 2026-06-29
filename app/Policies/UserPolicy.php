<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): Response
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny('Hanya admin yang dapat melihat daftar user.');
    }

    public function view(User $user, User $model): Response
    {
        return $user->isAdmin() || $user->id === $model->id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk melihat user ini.');
    }

    public function create(User $user): Response
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny('Hanya admin yang dapat menambah user.');
    }

    public function update(User $user, User $model): Response
    {
        return $user->isAdmin() || $user->id === $model->id
            ? Response::allow()
            : Response::deny('Anda tidak memiliki izin untuk mengubah user ini.');
    }

    public function delete(User $user, User $model): Response
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny('Hanya admin yang dapat menghapus user.');
    }

    public function restore(User $user, User $model): Response
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny('Hanya admin yang dapat mengembalikan user yang dihapus.');
    }

    public function forceDelete(User $user, User $model): Response
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny('Hanya admin yang dapat menghapus permanen user.');
    }
}
