<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubriks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rubrik');
            $table->string('nama_kolom_1');
            $table->string('nama_kolom_2');
            $table->string('nama_kolom_3');
            $table->string('nama_kolom_4');
            $table->integer('nama_kolom_5');
            $table->integer('nama_kolom_6');
            $table->integer('nama_kolom_7');
            $table->integer('nama_kolom_8');
            $table->date('nama_kolom_9');
            $table->date('nama_kolom_10');
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
        Schema::dropIfExists('rubriks');
    }
}
