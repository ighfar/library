<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('purchase_id')->nullable();
            $table->integer('category_id')->default(0);
            $table->string('detail')->nullable();
            $table->integer('qty')->default(0);
            $table->decimal('price', 26, 2)->default(0);
            $table->decimal('total', 26, 2)->default(0);
            $table->integer('orders')->default(1);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('purchase_details');
    }
}
