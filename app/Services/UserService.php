<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function getAllUsersExcludingAdmins()
    {
        return $this->userRepository->allWithoutAdmins();
    }

    public function getUserCount()
    {
        return $this->userRepository->count();
    }

    public function deleteUser($user)
    {
        return $this->userRepository->delete($user);
    }
}
