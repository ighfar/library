<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('supplier_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->string('code')->nullable();
            $table->date('date')->nullable();
            $table->integer('year')->default(0);
            $table->decimal('amount', 26, 2)->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('status_payment')->default(1);
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
        Schema::dropIfExists('purchase');
    }
}
