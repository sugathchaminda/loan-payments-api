<?php

namespace App\Http\Repositories;


use App\AddressType;

class AddressTypeRepositoryImpl implements AddressTypeRepository
{

    private $addressType;

    /**
     * Create a new controller instance.
     *
     * @param AddressType $addressType
     */
    public function __construct(AddressType $addressType)
    {
        $this->addressType = $addressType;
    }

    public function getAddressTypes()
    {
        return $this->addressType->all();
    }
}