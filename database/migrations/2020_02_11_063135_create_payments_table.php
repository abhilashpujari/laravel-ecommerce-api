<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payor_name');
            $table->string('payor_street_1')->nullable();
            $table->string('payor_street_2')->nullable();
            $table->string('payor_city')->nullable();
            $table->string('payor_state')->nullable();
            $table->string('payor_postal_code')->nullable();
            $table->string('payor_country')->nullable();
            $table->string('method');
            $table->string('transaction_id');
            $table->string('currency');
            $table->float('amount');
            $table->timestamp('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
