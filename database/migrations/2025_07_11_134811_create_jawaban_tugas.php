<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('jawaban_tugas', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_user');
    $table->unsignedBigInteger('id_tugas');
    $table->unsignedBigInteger('id_soal');
    $table->enum('jawaban', ['A', 'B', 'C', 'D']);
    $table->boolean('benar')->default(false);
    $table->timestamps();
    $table->foreign('id_tugas')->references('id')->on('tugas')->onDelete('cascade');
    $table->foreign('id_soal')->references('id')->on('soal_tugas')->onDelete('cascade');
    $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_tugas');
    }
};
