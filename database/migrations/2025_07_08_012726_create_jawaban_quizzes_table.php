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
        Schema::create('jawaban_quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_quiz');
            $table->text('isi_jawaban');
            $table->timestamps();
            $table->foreign('id_quiz')->references('id')->on('quizzes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_quizzes');
    }
};
