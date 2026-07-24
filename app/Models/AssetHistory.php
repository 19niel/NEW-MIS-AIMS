<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    protected $fillable = [
        'asset_id',
        'asset_tag',
        'action_type',
        'description',
        'previous_value',
        'new_value',
        'performed_by',
    ];

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
