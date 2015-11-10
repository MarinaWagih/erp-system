<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->enum('type',['sell','buy']);
            $table->float('additional_discount_percentage');
            $table->float('total_after_sales_tax');
            $table->integer('duration_expire')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->string('price_type');
            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
//                ->onDelete('set null');
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
        Schema::drop('invoices');
    }
}
