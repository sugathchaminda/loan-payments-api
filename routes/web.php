<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post(
        'login',
        [
            'uses' => 'AuthController@authenticate'
        ]
    );

    $router->post(
        'register',
        [
            'uses' => 'AuthController@register'
        ]
    );

    $router->get(
        'utils',
        [
            'uses' => 'AuthController@getUtils'
        ]
    );
});


$router->group(
    ['middleware' => 'jwt.auth', 'prefix' => 'auth'],
    function () use ($router) {
        $router->get(
            'users',
            [
                'uses' => 'AuthController@getAllUsers'
            ]
        );
    }
);

$router->group(
    ['middleware' => 'jwt.auth', 'prefix' => 'loan'],
    function () use ($router) {
        $router->post(
            '/',
            [
                'uses' => 'LoanController@addLoanForUser'
            ]
        );
        $router->get(
            '/',
            [
                'uses' => 'LoanController@getLoans'
            ]
        );
        $router->post(
            '/repayment',
            [
                'uses' => 'LoanController@payLoanInstallment'
            ]
        );
    }
);