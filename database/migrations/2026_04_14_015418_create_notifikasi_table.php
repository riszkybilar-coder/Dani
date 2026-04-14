<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();

            // penerima notifikasi (siswa)
            $table->unsignedBigInteger('nis')->nullable();

            // isi notifikasi
            $table->string('judul',100);
            $table->text('pesan');

            // tipe notifikasi
            $table->enum('tipe', [
                'aspirasi',
                'saran',
                'feedback',
                'umum'
            ])->default('umum');

            // status dibaca
            $table->boolean('dibaca')->default(false);

            $table->timestamps();

            // relasi ke siswa
            $table->foreign('nis')
                ->references('nis')
                ->on('siswas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};