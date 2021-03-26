<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsianRubriksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isian_rubriks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengguna_rubrik_id')->constrained('pengguna_rubriks');
            $table->unsignedBigInteger('nomor_sk')->constrained('rubriks');
            $table->unsignedBigInteger('periode_id')->constrained('periodes');
            $table->string('isian_1');
            $table->string('isian_2');
            $table->string('isian_3');
            $table->string('isian_4');
            $table->integer('isian_5');
            $table->integer('isian_6');
            $table->integer('isian_7');
            $table->integer('isian_8');
            $table->date('isian_9');
            $table->date('isian_10');
            $table->string('file_upload');
            $table->enum('status_validasi',['aktif','nonaktif']);
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
        Schema::dropIfExists('isian_rubriks');
    }
}
