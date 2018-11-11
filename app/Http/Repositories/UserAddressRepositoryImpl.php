<?php

namespace App\Http\Repositories;


use App\User;
use App\UserAddress;
use Illuminate\Http\Request;

class UserAddressRepositoryImpl implements UserAddressRepository
{

    private $userAddress;

    /**
     * Create a new controller instance.
     *
     * @param UserAddress $userAddress
     */
    public function __construct(UserAddress $userAddress)
    {
        $this->userAddress = $userAddress;
    }

    public function insertAddresses(User $user, array $addresses)
    {
        foreach ($addresses as $address) {
            $this->userAddress->address_line1 = $address["addressLine1"];
            $this->userAddress->address_line2 = $address["addressLine2"];
            $this->userAddress->city = $address["city"];
            $this->userAddress->state = $address["state"];
            $this->userAddress->country = $address["country"];
            $this->userAddress->zip_code = $address["zipCode"];
            $this->userAddress->user_id = $user->id;
            $this->userAddress->address_type_id = $address["addressTypeId"];
            $this->userAddress->status = 1;
            $this->userAddress->save();
        }
    }
}