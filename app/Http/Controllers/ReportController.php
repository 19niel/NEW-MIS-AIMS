<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Employee;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $totalEmployees = Employee::count();
        $totalUsers = User::count();
        
        $assetsByCategory = Asset::with('category')
            ->selectRaw('asset_category_id, count(*) as count')
            ->groupBy('asset_category_id')
            ->get();
            
        $assetsByCondition = Asset::selectRaw('`condition`, count(*) as count')
            ->groupBy('condition')
            ->get();
            
        return view('reports.index', compact('totalAssets', 'totalEmployees', 'totalUsers', 'assetsByCategory', 'assetsByCondition'));
    }
}
