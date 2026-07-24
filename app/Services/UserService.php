<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $repository)
    {
    }

    public function getAllUsers()
    {
        return $this->repository->getAll();
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->repository->create($data);
        
        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }
        return $user;
    }

    public function updateUser($id, array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->repository->update($id, $data);
        
        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }
        return $user;
    }

    public function deleteUser($id)
    {
        return $this->repository->delete($id);
    }
}
