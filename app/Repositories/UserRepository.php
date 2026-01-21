<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function count()
    {
        return User::count();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function allWithoutAdmins()
    {
        return User::where('role', '!=', 'admin')
            ->withCount('orders')
            ->latest()
            ->paginate(10);
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}
