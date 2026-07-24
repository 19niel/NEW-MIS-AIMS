<?php

namespace App\Services;

use App\Repositories\AssetRepository;
use App\Models\AssetCategory;
use Illuminate\Support\Facades\DB;

class AssetService
{
    public function __construct(protected AssetRepository $repository)
    {
    }

    public function getAllAssets()
    {
        return $this->repository->getAll();
    }
    
    public function getAllCategories()
    {
        return $this->repository->getAllCategories();
    }

    public function createAsset(array $data)
    {
        return DB::transaction(function () use ($data) {
            $category = AssetCategory::findOrFail($data['asset_category_id']);
            $data['asset_tag'] = $this->generateAssetTag($category);
            
            // Extract dynamic specs if any
            $specs = [];
            if (isset($data['ip_address'])) $specs['ip_address'] = $data['ip_address'];
            if (isset($data['mac_address'])) $specs['mac_address'] = $data['mac_address'];
            if (isset($data['os_version'])) $specs['os_version'] = $data['os_version'];
            if (isset($data['os_install_date'])) $specs['os_install_date'] = $data['os_install_date'];
            if (isset($data['processor'])) $specs['processor'] = $data['processor'];
            if (isset($data['antivirus'])) $specs['antivirus'] = $data['antivirus'];
            if (isset($data['antivirus_install_date'])) $specs['antivirus_install_date'] = $data['antivirus_install_date'];
            
            $data['specifications'] = $specs;

            $asset = $this->repository->create($data);

            // Handle RAM Modules
            if (isset($data['ram_capacity']) && isset($data['ram_type'])) {
                $asset->ramModules()->create([
                    'capacity' => $data['ram_capacity'],
                    'type' => $data['ram_type']
                ]);
            }

            // Handle Storage Drives
            if (isset($data['storage_size']) && isset($data['storage_type'])) {
                $asset->storageDrives()->create([
                    'size' => $data['storage_size'],
                    'type' => $data['storage_type'],
                    'model' => $data['storage_model'] ?? null,
                    'serial_number' => $data['storage_serial'] ?? null
                ]);
            }
            
            // Log Asset History
            \App\Models\AssetHistory::create([
                'asset_id' => $asset->id,
                'asset_tag' => $asset->asset_tag,
                'action_type' => 'Created',
                'description' => 'Asset registered into the system.',
                'performed_by' => auth()->id() ?? 1, // Fallback to 1 if no auth
            ]);

            if ($asset->assigned_to) {
                \App\Models\AssetHistory::create([
                    'asset_id' => $asset->id,
                    'asset_tag' => $asset->asset_tag,
                    'action_type' => 'Assigned',
                    'description' => 'Asset assigned to employee ID: ' . $asset->assigned_to,
                    'new_value' => (string)$asset->assigned_to,
                    'performed_by' => auth()->id() ?? 1,
                ]);
            }

            // Record Audit Log
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'Created',
                'module' => 'Assets',
                'description' => 'Registered new asset: ' . $asset->asset_tag,
                'ip_address' => request()->ip()
            ]);

            return $asset;
        });
    }

    public function updateAsset($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $asset = $this->repository->find($id);
            $oldAssignedTo = $asset->assigned_to;
            $oldCondition = $asset->condition;

            // Extract dynamic specs if any
            $specs = $asset->specifications ?? [];
            if (isset($data['ip_address'])) $specs['ip_address'] = $data['ip_address'];
            if (isset($data['mac_address'])) $specs['mac_address'] = $data['mac_address'];
            if (isset($data['os_version'])) $specs['os_version'] = $data['os_version'];
            if (isset($data['os_install_date'])) $specs['os_install_date'] = $data['os_install_date'];
            if (isset($data['processor'])) $specs['processor'] = $data['processor'];
            if (isset($data['antivirus'])) $specs['antivirus'] = $data['antivirus'];
            if (isset($data['antivirus_install_date'])) $specs['antivirus_install_date'] = $data['antivirus_install_date'];
            
            $data['specifications'] = $specs;

            $this->repository->update($id, $data);
            
            // For simplicity, we can update or clear RAM/Storage. Let's recreate them.
            if (isset($data['ram_capacity'])) {
                $asset->ramModules()->delete();
                $asset->ramModules()->create([
                    'capacity' => $data['ram_capacity'],
                    'type' => $data['ram_type']
                ]);
            }

            if (isset($data['storage_size'])) {
                $asset->storageDrives()->delete();
                $asset->storageDrives()->create([
                    'size' => $data['storage_size'],
                    'type' => $data['storage_type'],
                    'model' => $data['storage_model'] ?? null,
                    'serial_number' => $data['storage_serial'] ?? null
                ]);
            }
            
            $asset->refresh();

            // Track Assigned To change
            if ($oldAssignedTo != $asset->assigned_to) {
                $action = $asset->assigned_to ? 'Assigned' : 'Unassigned';
                $desc = $asset->assigned_to 
                    ? "Asset assigned to employee ID: " . $asset->assigned_to
                    : "Asset unassigned from employee ID: " . $oldAssignedTo;
                    
                \App\Models\AssetHistory::create([
                    'asset_id' => $asset->id,
                    'asset_tag' => $asset->asset_tag,
                    'action_type' => $action,
                    'description' => $desc,
                    'previous_value' => (string)$oldAssignedTo,
                    'new_value' => (string)$asset->assigned_to,
                    'performed_by' => auth()->id() ?? 1,
                ]);
            }

            // Track Condition change
            if ($oldCondition != $asset->condition) {
                \App\Models\AssetHistory::create([
                    'asset_id' => $asset->id,
                    'asset_tag' => $asset->asset_tag,
                    'action_type' => 'Condition Changed',
                    'description' => 'Asset condition changed from ' . $oldCondition . ' to ' . $asset->condition,
                    'previous_value' => $oldCondition,
                    'new_value' => $asset->condition,
                    'performed_by' => auth()->id() ?? 1,
                ]);
            }

            // Record Audit Log
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'Updated',
                'module' => 'Assets',
                'description' => 'Updated asset: ' . $asset->asset_tag,
                'ip_address' => request()->ip()
            ]);

            return $asset;
        });
    }

    public function deleteAsset($id)
    {
        return $this->repository->delete($id);
    }

    private function generateAssetTag(AssetCategory $category)
    {
        $prefix = strtoupper(substr($category->slug, 0, 3));
        $lastAsset = \App\Models\Asset::where('asset_category_id', $category->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastAsset && preg_match('/-(\d+)$/', $lastAsset->asset_tag, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }

        return $prefix . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
