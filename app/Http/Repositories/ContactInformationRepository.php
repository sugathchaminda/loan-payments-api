<?php

namespace App\Http\Repositories;


use App\User;
use Illuminate\Http\Request;

interface ContactInformationRepository
{
    public function insertContacts($user, array $contacts);
}