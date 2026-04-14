<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';
    
    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas',
        'kategori_id',
        'ket_kategori',
        'keterangan',
        'foto',
        'status',
        'feedback',
        'is_anonim',
        'user_id'
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Scope untuk filter status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessor untuk nama yang dianonimkan
    public function getDisplayNameAttribute()
    {
        if ($this->is_anonim) {
            return 'Anonim';
        }
        return $this->nama_siswa;
    }

    // Accessor untuk NIS yang dianonimkan
    public function getDisplayNisAttribute()
    {
        if ($this->is_anonim) {
            return '***';
        }
        return $this->nis;
    }
}