<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Kantor;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // nama table
    protected $table = 'users';
    // nama primary key
    protected $primaryKey = 'user_id';
    // agar bisa menambahkan dan memperbarui data secara masal
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getPeranFormattedAttribute()
    {
        // uckata2x ganti '_' jadi spasi pada value column peran
        return ucwords(str_replace('_', ' ', $this->peran));
    }


    /**
     * Relasi ke Tabel Kantor.
     * Setiap User bernaung di bawah satu Kantor.
     */
    public function kantor(): BelongsTo
    {
        // foreign_key (kantor_id): Ini adalah kolom yang ada di tabel saat ini (tabel users). Ini adalah kolom yang "menyimpan" ID dari kantor.
        // owner_key (kantor_id): Ini adalah kolom referensi di tabel target (tabel kantor). Biasanya ini adalah Primary Key dari tabel tujuan. 
        return $this->belongsTo(Kantor::class, 'kantor_id', 'kantor_id');
    }

    /**
     * Relasi ke Tabel Dokumen (sebagai pengunggah).
     */
    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke Tabel Dokumen (sebagai penyetuju/penandatangan).
     */
    public function dokumenDisetujui(): HasMany
    {
        return $this->hasMany(Dokumen::class, 'disetujui_oleh', 'user_id');
    }

    // =========================================================================
    // HELPER METHODS & SCOPES
    // =========================================================================

    /**
     * Cek apakah user adalah Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->peran === 'super_admin';
    }

    /**
     * Scope untuk mempermudah filter berdasarkan peran di Controller.
     * Contoh penggunaan: User::role('staff')->get();
     */
    public function scopeRole($query, $role)
    {
        return $query->where('peran', $role);
    }

    /**
     * Aksesor untuk mendapatkan URL tanda tangan yang valid.
     */
    public function getSignatureUrlAttribute()
    {
        return $this->jalur_gambar_tanda_tangan
            ? asset('storage/' . $this->jalur_gambar_tanda_tangan)
            : asset('images/default-signature.png');
    }
}
