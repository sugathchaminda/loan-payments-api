<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('loan_amount', 15, 2)->nullable(false);
            $table->decimal('arrangement_fee', 15, 2)->nullable(false);
            $table->decimal('installment_amount', 15, 2)->nullable(false);
            $table->integer('duration')->nullable(false);
            $table->integer('repayment_frequency')->nullable(false);
            $table->float('interest_rate', 10, 2)->nullable(false);
            $table->decimal('loan_balance_amount', 15, 2)->nullable(false);
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
        Schema::dropIfExists('loans');
    }
}
