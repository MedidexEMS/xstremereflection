<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('qty');
            $table->integer('invoiceId');
            $table->integer('packageId');
            $table->integer('discount')->nullable();
            $table->integer('discountType')->nullable();
            $table->decimal('total', 8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_services');
    }
}
