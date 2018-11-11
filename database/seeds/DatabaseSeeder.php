<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();
        // Register the user seeder
        $this->call(UserRolesTableSeeder::class);
        $this->call(AddressTypesTableSeeder::class);
        $this->call(ContactTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        \Illuminate\Database\Eloquent\Model::reguard();
    }
}
