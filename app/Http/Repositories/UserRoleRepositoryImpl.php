<?php

namespace App\Http\Repositories;


use App\UserRole;

class UserRoleRepositoryImpl implements UserRoleRepository
{

    private $userRole;

    /**
     * Create a new controller instance.
     *
     * @param UserRole $userRole
     */
    public function __construct(UserRole $userRole)
    {
        $this->userRole = $userRole;
    }

    public function getUserRoles()
    {
        return $this->userRole->all();
    }
}
