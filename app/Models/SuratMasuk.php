<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class SuratMasuk extends Model
{
    protected $table      = 'surat_masuk';
    protected $primaryKey = 'id_surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'tgl_surat',
        'tgl_diterima',
        'asal_surat',
        'perihal',
        'file_pdf',
        'id_kategori',
    ];

    protected function casts(): array
    {
        return [
            'tgl_surat'    => 'date',
            'tgl_diterima' => 'date',
        ];
    }

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSurat::class, 'id_kategori', 'id_kategori');
    }

    public function disposisi(): HasOne
    {
        return $this->hasOne(Disposisi::class, 'id_surat_masuk', 'id_surat_masuk');
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    public function getDownloadUrl(): ?string
    {
        if (!$this->file_pdf) {
            return null;
        }

        return Storage::url($this->file_pdf);
    }

    public function hasFile(): bool
    {
        return !empty($this->file_pdf) && Storage::exists($this->file_pdf);
    }
}
