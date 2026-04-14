<?php


use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;


return new class extends Migration

{

    /**

     * Run the migrations.

     */

    public function up(): void

    {

        Schema::create('feedbacks', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('id_aspirasi')->unique(); // unique = 1 feedback per aspirasi

            $table->text('isi_feedback');

            $table->timestamps();


            $table->foreign('id_aspirasi')

                  ->references('id_aspirasi')

                  ->on('aspirasis')

                  ->onDelete('cascade');

        });

    }


    /**

     * Reverse the migrations.

     */

    public function down(): void

    {

        Schema::dropIfExists('feedback');

    }

};

