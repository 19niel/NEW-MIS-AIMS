<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetCategory;

class AssetCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'data' => AssetCategory::all()
            ]);
        }
        
        return view('settings.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:asset_categories,name',
            'slug' => 'required|string|unique:asset_categories,slug',
            'description' => 'nullable|string'
        ]);

        AssetCategory::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Asset category added successfully!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = AssetCategory::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|unique:asset_categories,name,' . $id,
            'slug' => 'required|string|unique:asset_categories,slug,' . $id,
            'description' => 'nullable|string'
        ]);

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Asset category updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $category = AssetCategory::findOrFail($id);
        
        if ($category->assets()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category because it has assets assigned to it.'
            ], 400);
        }
        
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Asset category deleted successfully!'
        ]);
    }
}
