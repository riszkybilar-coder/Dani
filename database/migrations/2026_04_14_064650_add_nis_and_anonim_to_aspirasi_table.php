<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            if (!Schema::hasColumn('aspirasi', 'nis')) {
                $table->string('nis', 20)->nullable()->after('id');
            }
            if (!Schema::hasColumn('aspirasi', 'is_anonim')) {
                $table->boolean('is_anonim')->default(false)->after('nis');
            }
            if (!Schema::hasColumn('aspirasi', 'foto')) {
                $table->string('foto')->nullable()->after('keterangan');
            }
        });
    }

    public function down()
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            $table->dropColumn(['nis', 'is_anonim', 'foto']);
        });
    }
};