<?php

namespace App\Http\Repositories;


use App\ContactInformation;
use App\User;
use Illuminate\Http\Request;

class ContactInformationRepositoryImpl implements ContactInformationRepository
{

    private $contactInformation;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @param User $user
     * @param ContactInformation $contactInformation
     */
    public function __construct(ContactInformation $contactInformation)
    {
        $this->contactInformation = $contactInformation;
    }

    public function getUsersWithFilters(Request $request)
    {
        if($request->has("userId")){

        }
    }

    /**
     * @param $user
     * @param array $contacts
     */
    public function insertContacts($user, array $contacts)
    {
        foreach ($contacts as $contact) {
            $this->contactInformation->country_code = $contact["countryCode"];
            $this->contactInformation->contact_number = $contact["contactNumber"];
            $this->contactInformation->user_id = $user->id;
            $this->contactInformation->contact_type_id = $contact["contactTypeId"];
            $this->contactInformation->status = 1;

            $this->contactInformation->save();
        }
    }
}