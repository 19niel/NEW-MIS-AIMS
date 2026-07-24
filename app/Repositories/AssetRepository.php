<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\AssetCategory;

class AssetRepository
{
    public function getAll()
    {
        return Asset::with(['category', 'assignedEmployee'])->latest()->get();
    }
    
    public function getAllCategories()
    {
        return AssetCategory::all();
    }

    public function create(array $data)
    {
        return Asset::create($data);
    }

    public function find($id)
    {
        return Asset::with(['category', 'ramModules', 'storageDrives'])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $asset = $this->find($id);
        $asset->update($data);
        return $asset;
    }

    public function delete($id)
    {
        $asset = $this->find($id);
        return $asset->delete();
    }
}
