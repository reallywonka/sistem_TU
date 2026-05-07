<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id('id_disposisi');
            $table->foreignId('id_surat_masuk')
                  ->constrained('surat_masuk', 'id_surat_masuk')
                  ->cascadeOnDelete();
            $table->foreignId('id_penerima')
                  ->constrained('users', 'id_user')
                  ->restrictOnDelete();
            $table->text('instruksi');
            $table->enum('status_tugas', ['belum_dibaca', 'sedang_diproses', 'selesai'])
                  ->default('belum_dibaca');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
