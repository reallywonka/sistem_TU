<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_lengkap',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // -------------------------------------------------------
    // Relationships
    // -------------------------------------------------------

    public function disposisis(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'id_penerima', 'id_user');
    }

    // -------------------------------------------------------
    // Role helpers
    // -------------------------------------------------------

    public function isAdminTU(): bool
    {
        return $this->role === 'admin_tu';
    }

    public function isKepsek(): bool
    {
        return $this->role === 'kepala_sekolah';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}
