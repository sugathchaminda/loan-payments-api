<?php

namespace App\Providers;

use App\Http\Repositories\AddressTypeRepository;
use App\Http\Repositories\AddressTypeRepositoryImpl;
use App\Http\Repositories\ContactInformationRepository;
use App\Http\Repositories\ContactInformationRepositoryImpl;
use App\Http\Repositories\ContactTypeRepository;
use App\Http\Repositories\ContactTypeRepositoryImpl;
use App\Http\Repositories\LoanRepaymentLogRepository;
use App\Http\Repositories\LoanRepaymentLogRepositoryImpl;
use App\Http\Repositories\LoanRepository;
use App\Http\Repositories\LoanRepositoryImpl;
use App\Http\Repositories\UserAddressRepository;
use App\Http\Repositories\UserAddressRepositoryImpl;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\UserRepositoryImpl;
use App\Http\Repositories\UserRoleRepository;
use App\Http\Repositories\UserRoleRepositoryImpl;
use App\Http\Services\AuthService;
use App\Http\Services\AuthServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepository::class,
            UserRepositoryImpl::class
        );

        $this->app->bind(
            UserAddressRepository::class,
            UserAddressRepositoryImpl::class
        );

        $this->app->bind(
            ContactInformationRepository::class,
            ContactInformationRepositoryImpl::class
        );

        $this->app->bind(
            UserRoleRepository::class,
            UserRoleRepositoryImpl::class
        );

        $this->app->bind(
            ContactTypeRepository::class,
            ContactTypeRepositoryImpl::class
        );

        $this->app->bind(
            AddressTypeRepository::class,
            AddressTypeRepositoryImpl::class
        );

        $this->app->bind(
            LoanRepository::class,
            LoanRepositoryImpl::class
        );

        $this->app->bind(
            LoanRepaymentLogRepository::class,
            LoanRepaymentLogRepositoryImpl::class
        );
    }
}
