<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposisi extends Model
{
    protected $table      = 'disposisi';
    protected $primaryKey = 'id_disposisi';

    protected $fillable = [
        'id_surat_masuk',
        'id_penerima',
        'instruksi',
        'status_tugas',
    ];

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class, 'id_surat_masuk', 'id_surat_masuk');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_penerima', 'id_user');
    }

    // -------------------------------------------------------
    // Helpers
    // -------------------------------------------------------

    /**
     * Update status disposisi.
     *
     * @param  string  $status  belum_dibaca|sedang_diproses|selesai
     */
    public function updateStatus(string $status): bool
    {
        return $this->update(['status_tugas' => $status]);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_tugas) {
            'belum_dibaca'    => 'Belum Dibaca',
            'sedang_diproses' => 'Sedang Diproses',
            'selesai'         => 'Selesai',
            default           => 'Tidak Diketahui',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status_tugas) {
            'belum_dibaca'    => 'red',
            'sedang_diproses' => 'yellow',
            'selesai'         => 'green',
            default           => 'gray',
        };
    }
}
