<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRamModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'capacity',
        'type',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
