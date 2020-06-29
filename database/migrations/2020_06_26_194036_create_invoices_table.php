<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('companyId');
            $table->integer('customerId');
            $table->string('serviceAddress')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->time('arrivalTime')->nullable();
            $table->time('estimatedCompleteTime')->nullable();
            $table->integer('status');
            $table->year('vehicleYear')->nullable();
            $table->string('vehicleMake')->nullable();
            $table->string('vehicleModel')->nullable();
            $table->string('vehicleColor')->nullable();
            $table->string('vehicleVin')->nullable();
            $table->integer('vehicleCondition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
