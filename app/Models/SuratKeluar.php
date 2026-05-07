<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SuratKeluar extends Model
{
    protected $table      = 'surat_keluar';
    protected $primaryKey = 'id_surat_keluar';

    protected $fillable = [
        'nomor_surat',
        'tgl_surat',
        'tujuan_surat',
        'perihal',
        'file_pdf',
        'id_kategori',
    ];

    protected function casts(): array
    {
        return [
            'tgl_surat' => 'date',
        ];
    }

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriSurat::class, 'id_kategori', 'id_kategori');
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
