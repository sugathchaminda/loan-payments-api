<?php

namespace App\Http\Repositories;

use App\ContactType;

class ContactTypeRepositoryImpl implements ContactTypeRepository
{

    private $contactType;

    /**
     * Create a new controller instance.
     *
     * @param ContactType $contactType
     */
    public function __construct(ContactType $contactType)
    {
        $this->contactType = $contactType;
    }

    public function getContactTypes()
    {
        return $this->contactType->all();
    }
}
