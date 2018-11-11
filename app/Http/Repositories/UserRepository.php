<?php

namespace App\Http\Repositories;


use Illuminate\Http\Request;

interface UserRepository
{
    public function getUsersWithFilters(Request $request);

    public function getUserByEmail($input);

    public function insertUser(array $all);

}