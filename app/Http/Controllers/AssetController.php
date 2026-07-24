<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AssetService;

class AssetController extends Controller
{
    public function __construct(protected AssetService $assetService)
    {
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'data' => $this->assetService->getAllAssets()
            ]);
        }
        
        $categories = $this->assetService->getAllCategories();
        $employees = \App\Models\Employee::whereIn('employment_status', ['Active', 'Probationary'])->get();
        return view('assets.index', compact('categories', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asset_category_id' => 'required|exists:asset_categories,id',
            'assigned_to' => 'nullable|exists:employees,id',
            'serial_number' => 'nullable|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'arrival_date' => 'nullable|date',
            'deployment_date' => 'nullable|date',
            'condition' => 'required|string',
            
            // Computer Specific Fields
            'ip_address' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'os_version' => 'nullable|string',
            'os_install_date' => 'nullable|date',
            'processor' => 'nullable|string',
            'antivirus' => 'nullable|string',
            'antivirus_install_date' => 'nullable|date',
            
            // RAM
            'ram_capacity' => 'nullable|string',
            'ram_type' => 'nullable|string',
            
            // Storage
            'storage_size' => 'nullable|string',
            'storage_type' => 'nullable|string',
        ]);

        $asset = $this->assetService->createAsset($data);

        return response()->json([
            'success' => true,
            'message' => 'Asset registered successfully with tag: ' . $asset->asset_tag,
            'data' => $asset
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'asset_category_id' => 'required|exists:asset_categories,id',
            'assigned_to' => 'nullable|exists:employees,id',
            'serial_number' => 'nullable|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'arrival_date' => 'nullable|date',
            'deployment_date' => 'nullable|date',
            'condition' => 'required|string',
            
            // Computer Specific Fields
            'ip_address' => 'nullable|string',
            'mac_address' => 'nullable|string',
            'os_version' => 'nullable|string',
            'os_install_date' => 'nullable|date',
            'processor' => 'nullable|string',
            'antivirus' => 'nullable|string',
            'antivirus_install_date' => 'nullable|date',
            
            // RAM
            'ram_capacity' => 'nullable|string',
            'ram_type' => 'nullable|string',
            
            // Storage
            'storage_size' => 'nullable|string',
            'storage_type' => 'nullable|string',
        ]);

        $this->assetService->updateAsset($id, $data);

        return response()->json([
            'success' => true,
            'message' => 'Asset updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $this->assetService->deleteAsset($id);

        return response()->json([
            'success' => true,
            'message' => 'Asset deleted successfully!'
        ]);
    }

    public function history($id)
    {
        $history = \App\Models\AssetHistory::with('performer')
            ->where('asset_id', $id)
            ->latest()
            ->get();
            
        return response()->json($history);
    }
}
