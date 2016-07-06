<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrices', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('size');
            $table->timestamps();
        });

        Schema::create('cells', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('matrix_id')->unsigned();
            $table->integer('x')->unsigned();
            $table->integer('y')->unsigned();
            $table->integer('z')->unsigned();
            $table->integer('value');
            $table->index(['matrix_id','x','y','z']);
            $table->unique(['matrix_id','x','y','z']);
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
        Schema::drop('cells');
        Schema::drop('matrices');
    }
}
