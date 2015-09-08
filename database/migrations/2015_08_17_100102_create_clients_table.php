<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('email');
            $table->string('fax');
            $table->string('phone')->unique();
            $table->string('mobile')->unique();
            $table->string('trading_name');
            $table->string('trading_address');
            $table->date('date');
            $table->integer('representative_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('representative_id')
                ->references('id')
                ->on('representatives')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
