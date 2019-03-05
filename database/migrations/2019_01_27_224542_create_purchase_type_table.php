<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_number_debit')->default(0);
            $table->integer('account_number_credit')->default(0);
            $table->string('name')->nullable();
            $table->integer('orders')->default(1);
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
        Schema::dropIfExists('purchase_type');
    }
}
