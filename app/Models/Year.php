<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    use HasFactory;
    protected $table = "years";

    protected $fillable = [
        'year_name',
        'year_status',
    ];

    public function guest(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}
