<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('estimateId');
            $table->integer('quanity')->default(1);
            $table->integer('serviceId');
            $table->integer('discount')->default(0);
            $table->integer('discountType');
            $table->decimal('listPrice', 6, 2);
            $table->decimal('chargedPrice', 7, 2);
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimate_services');
    }
}
