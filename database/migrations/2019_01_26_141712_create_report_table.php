<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('reference_id')->nullable();
            $table->string('module')->nullable();
            $table->text('additional_info')->nullable();
            $table->date('date')->nullable();
            $table->integer('year')->default(0);
            $table->integer('account_number')->default(0);
            $table->string('info')->nullable();
            $table->decimal('amount', 26, 2)->default(0);
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
        Schema::dropIfExists('report');
    }
}
