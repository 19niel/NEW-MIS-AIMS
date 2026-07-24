<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetStorageDrive extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'model',
        'size',
        'type',
        'serial_number',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
