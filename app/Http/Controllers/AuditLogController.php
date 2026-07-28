<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'data' => AuditLog::with('user')->orderBy('created_at', 'desc')->get()
            ]);
        }
        
        return view('audit-logs.index');
    }
}
