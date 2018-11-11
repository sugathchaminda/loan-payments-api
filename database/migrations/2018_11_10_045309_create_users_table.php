<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string("first_name", 100)->nullable(false);
            $table->string("last_name", 100)->nullable(false);
            $table->string("email", 150)->unique()->nullable(false)->index();
            $table->string("password", 100)->nullable(false);
            $table->date("date_of_birth")->nullable(false);
            $table->integer("gender")->nullable(false)->comment("0 - male, 1 - female");
            $table->string("nic", 15)->unique()->nullable(false);
            $table->unsignedInteger('user_role_id');
            $table->foreign('user_role_id')->references('id')->on('user_roles')->onDelete('cascade');
            $table->integer("status")->nullable(false)
                ->comment("0 - pending, 1 - activate, 2 - deactivate");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
