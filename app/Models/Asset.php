<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_tag',
        'asset_category_id',
        'assigned_to',
        'serial_number',
        'brand',
        'model',
        'purchase_date',
        'arrival_date',
        'deployment_date',
        'condition',
        'status',
        'specifications',
    ];

    protected $casts = [
        'specifications' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function ramModules()
    {
        return $this->hasMany(AssetRamModule::class);
    }

    public function storageDrives()
    {
        return $this->hasMany(AssetStorageDrive::class);
    }
}
