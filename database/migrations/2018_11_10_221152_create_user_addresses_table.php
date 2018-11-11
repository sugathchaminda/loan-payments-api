<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string("address_line1")->nullable(false);
            $table->string("address_line2")->nullable(false);
            $table->string("city", 25)->nullable(false);
            $table->string("state", 25)->nullable(false);
            $table->string("country", 25)->nullable(false);
            $table->string("zip_code")->nullable(false);
            $table->unsignedInteger('address_type_id');
            $table->foreign('address_type_id')->references('id')->on('address_types')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_addresses');
    }
}
