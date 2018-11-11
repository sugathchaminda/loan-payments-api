<?php

namespace App\Http\Repositories;


use App\User;
use Illuminate\Http\Request;

/**
 * Class UserRepositoryImpl
 * @package App\Http\Repositories
 */
class UserRepositoryImpl implements UserRepository
{

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUsersWithFilters(Request $request)
    {
        $users = $this->user->with(['ContactInformation' => function ($query) {
            $query->with("ContactType")->where('status', 1);

        }])->with(['UserAddresses' => function ($query) {
            $query->with("AddressType")->where('status', 1);

        }])->with("UserRole");


        if ($request->has("userId")) {
            $users->where('id', $request->get("userId"));
        }

        if ($request->has("email")) {
            $users->where('email', $request->get("email"));
        }

        if ($request->has("firstName")) {
            $users->where('first_name', 'like', "%" . $request->get("firstName") . "%");
        }

        $users->where('status', 1);

        return $users->paginate($request->get("pageSize"));
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    /**
     * @param array $user
     * @return User
     */
    public function insertUser(array $user)
    {
        $this->user->first_name = $user["firstName"];
        $this->user->last_name = $user["lastName"];
        $this->user->email = $user["email"];
        $this->user->password = app('hash')->make($user["password"]);
        $this->user->date_of_birth = $user["dateOfBirth"];
        $this->user->gender = $user["gender"];
        $this->user->nic = $user["nic"];
        $this->user->user_role_id = $user["userRoleId"];
        $this->user->status = 1;

        $this->user->save();

        return $this->user;
    }
}