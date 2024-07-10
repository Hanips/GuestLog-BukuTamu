<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    use HasFactory;

    public const STATUS = ['done', 'ongoing'];

    protected $casts = [
        'tgl_kunjungan' => 'date',
    ];
    
    protected $fillable = [
        'user_id',
        'year_id',
        'nama',
        'NIP',
        'jabatan',
        'instansi',
        'no_telp',
        'email',
        'alamat',
        'tgl_kunjungan',
        'waktu_masuk',
        'waktu_keluar',
        'status',
        'signature',
        'keperluan',
        'saran',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }
}
