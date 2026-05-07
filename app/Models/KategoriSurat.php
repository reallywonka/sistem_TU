<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSurat extends Model
{
    protected $table      = 'kategori_surat';
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori'];

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function suratMasuks(): HasMany
    {
        return $this->hasMany(SuratMasuk::class, 'id_kategori', 'id_kategori');
    }

    public function suratKeluars(): HasMany
    {
        return $this->hasMany(SuratKeluar::class, 'id_kategori', 'id_kategori');
    }
}
