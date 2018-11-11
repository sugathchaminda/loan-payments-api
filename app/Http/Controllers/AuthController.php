<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AddressTypeRepository;
use App\Http\Repositories\ContactInformationRepository;
use App\Http\Repositories\ContactTypeRepository;
use App\Http\Repositories\UserAddressRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\UserRoleRepository;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    private $userRepository;
    private $contactInformationRepository;
    private $userAddressRepository;
    private $userRoleRepository;
    private $contactTypeRepository;
    private $addressTypeRepository;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @param ContactInformationRepository $contactInformationRepository
     * @param UserAddressRepository $userAddressRepository
     * @param UserRoleRepository $userRoleRepository
     * @param ContactTypeRepository $contactTypeRepository
     * @param AddressTypeRepository $addressTypeRepository
     */
    public function __construct(Request $request, UserRepository $userRepository
        , ContactInformationRepository $contactInformationRepository, UserAddressRepository $userAddressRepository
        , UserRoleRepository $userRoleRepository, ContactTypeRepository $contactTypeRepository
        , AddressTypeRepository $addressTypeRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
        $this->contactInformationRepository = $contactInformationRepository;
        $this->userAddressRepository = $userAddressRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->contactTypeRepository = $contactTypeRepository;
        $this->addressTypeRepository = $addressTypeRepository;
    }

    /**
     * Create a new token.
     *
     * @param User $user
     * @return string
     */
    protected function jwt(User $user)
    {
        $payload = [
            'iss' => "loan-application", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        try {
            $this->validate($this->request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Find the user by email
            $user = $this->userRepository->getUserByEmail($this->request->input('email'));

            if (!$user) {
                Log::error("Email does not exist. email : " . $this->request->input('email'));
                return response()->json([
                    'data' => null,
                    'status' => false,
                    'message' => 'Email does not exist.'
                ], 400);
            }

            // Verify the password and generate the token
            if (Hash::check($this->request->input('password'), $user->password)) {
                return response()->json([
                    'data' => [
                        'token' => $this->jwt($user),
                        'user' => $user
                    ],
                    'status' => true,
                    'message' => 'Successfully logged in.'
                ], 200);
            }

            Log::error("Email or password is wrong. email : " . $this->request->input('email'));

            // Bad Request response
            return response()->json([
                'data' => null,
                'status' => false,
                'message' => 'Email or password is wrong.'
            ], 400);

        } catch (\Exception $ex) {

            Log::error("Logging User.: {} " . $ex);

            return response()->json([
                'data' => $ex,
                'status' => false,
                'message' => "Failed to logging."
            ], 500);
        }
    }

    /**
     * Register new user
     *
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register()
    {
        DB::beginTransaction();

        try {
            $this->validate($this->request, [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'dateOfBirth' => 'required',
                'gender' => 'required',
                'nic' => 'required',
                'userRoleId' => 'required',
                'contacts' => 'required|array',
                'contacts.*.countryCode' => 'required',
                'contacts.*.contactNumber' => 'required',
                'contacts.*.contactTypeId' => 'required',
                'addresses' => 'required|array',
                'addresses.*.addressLine1' => 'required',
                'addresses.*.addressLine2' => 'required',
                'addresses.*.city' => 'required',
                'addresses.*.state' => 'required',
                'addresses.*.country' => 'required',
                'addresses.*.zipCode' => 'required',
                'addresses.*.addressTypeId' => 'required',
            ]);

            //insert user
            $user = $this->userRepository->insertUser($this->request->all('firstName', 'lastName', 'email', 'password'
                , 'dateOfBirth', 'gender', 'nic', 'userRoleId'));

            //insert contacts
            $this->contactInformationRepository->insertContacts($user, $this->request->get('contacts'));

            //insert addresses
            $this->userAddressRepository->insertAddresses($user, $this->request->get('addresses'));

            DB::commit();

            return response()->json([
                'data' => [
                    'token' => $this->jwt($user),
                    'user' => $user
                ],
                'status' => true,
                'message' => 'Successfully registered.'
            ], 200);

        } catch (\Exception $ex) {

            DB::rollback();

            Log::error("Register User.: {} " . $ex);

            return response()->json([
                'data' => $ex,
                'status' => false,
                'message' => "Failed to register user."
            ], 500);
        }
    }

    public function getAllUsers()
    {
        try {

            $users = $this->userRepository->getUsersWithFilters($this->request);

            return response()->json([
                'data' => [
                    'users' => $users
                ],
                'status' => true,
                'message' => 'User list received.'
            ], 200);

        } catch (\Exception $ex) {

            Log::error("Get Users.: {} " . $ex);

            return response()->json([
                'data' => $ex,
                'status' => false,
                'message' => "Failed to get users."
            ], 500);
        }
    }

    public function getUtils()
    {
        try {
            $userRoles = $this->userRoleRepository->getUserRoles();
            $contactTypes = $this->contactTypeRepository->getContactTypes();
            $addressTypes = $this->addressTypeRepository->getAddressTypes();

            return response()->json([
                'data' => [
                    'userRoles' => $userRoles,
                    'contactTypes' => $contactTypes,
                    'addressTypes' => $addressTypes
                ],
                'status' => true,
                'message' => 'Utilities for application.'
            ], 200);

        } catch (\Exception $ex) {

            Log::error("Get Utilities For Application.: {} " . $ex);
            
            return response()->json([
                'data' => $ex,
                'status' => false,
                'message' => "Failed to get utilities for application."
            ], 500);
        }
    }
}
