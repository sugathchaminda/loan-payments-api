<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanRepaymentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_repayment_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('payed_amount', 15, 2)->nullable(false);
            $table->decimal('loan_balance_amount', 15, 2)->nullable(false);
            $table->date('payed_date')->nullable(false)->index();
            $table->unsignedInteger('loan_id');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
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
        Schema::dropIfExists('loan_repayment_logs');
    }
}
