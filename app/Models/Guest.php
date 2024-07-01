<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    use HasFactory;

    public const STATUS = ['done', 'ongoing'];

    protected $fillable = [
        'user_id',
        'year_id',
        'nama',
        'instansi',
        'no_telp',
        'email',
        'alamat',
        'keperluan',
        'tgl_kunjungan',
        'waktu_masuk',
        'waktu_keluar',
        'status',
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
