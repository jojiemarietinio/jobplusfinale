<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_number');
            $table->string('transaction_id');
            $table->string('currency_code');
            $table->string('payment_status');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::drop("payments");
    }
}