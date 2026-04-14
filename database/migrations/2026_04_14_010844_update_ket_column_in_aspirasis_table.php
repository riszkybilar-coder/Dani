<?php


use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;


return new class extends Migration

{

    public function up(): void

    {

        Schema::table('aspirasis', function (Blueprint $table) {

            //$table->string('foto')->after('ket'); // ← wajib, tidak nullable

        });

    }


    public function down(): void

    {

        Schema::table('aspirasis', function (Blueprint $table) {

            $table->dropColumn('foto');

        });

    }

};