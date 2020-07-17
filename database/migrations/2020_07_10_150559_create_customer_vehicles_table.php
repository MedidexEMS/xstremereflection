<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('customerId');
            $table->year('year');
            $table->string('make', 60);
            $table->string('model', 60);
            $table->string('trim', 60);
            $table->integer('color');
            $table->integer('customerCondition')->nullable();
            $table->integer('technicianCondition')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_vehicles');
    }
}
