<?php


use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;


return new class extends Migration

{

    public function up(): void

    {

        Schema::table('aspirasis', function (Blueprint $table) {

            // Ubah nis menjadi nullable agar bisa anonim

            $table->unsignedBigInteger('nis')->nullable()->change();

        });

    }


    public function down(): void

    {

        Schema::table('aspirasis', function (Blueprint $table) {

            $table->unsignedBigInteger('nis')->nullable(false)->change();

        });

    }

};