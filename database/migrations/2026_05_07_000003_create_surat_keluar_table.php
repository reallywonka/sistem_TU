<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id('id_surat_keluar');
            $table->string('nomor_surat', 50);
            $table->date('tgl_surat');
            $table->string('tujuan_surat', 100);
            $table->string('perihal', 255);
            $table->string('file_pdf', 255)->nullable();
            $table->foreignId('id_kategori')
                  ->constrained('kategori_surat', 'id_kategori')
                  ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
