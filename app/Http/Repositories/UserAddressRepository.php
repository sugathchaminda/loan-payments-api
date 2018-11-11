<?php

namespace App\Http\Repositories;


use App\User;
use Illuminate\Http\Request;

interface UserAddressRepository
{

    public function insertAddresses(User $user, array $addresses);
}