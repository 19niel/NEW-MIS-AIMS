<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $employeeService)
    {
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'data' => $this->employeeService->getAllEmployees()
            ]);
        }
        return view('employees.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'department' => 'required|string',
            'position' => 'required|string',
            'email' => 'required|email|unique:employees',
            'contact_number' => 'nullable|string',
            'date_hired' => 'nullable|date',
            'date_separated' => 'nullable|date',
            'employment_status' => 'required|string',
            'location' => 'nullable|string',
            'remarks' => 'nullable|string',
            'accountability_form' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'
        ]);

        if ($request->hasFile('accountability_form')) {
            $path = $request->file('accountability_form')->store('accountability_forms', 'public');
            $data['accountability_form'] = $path;
        }

        $employee = $this->employeeService->createEmployee($data);

        return response()->json([
            'success' => true,
            'message' => 'Employee registered successfully!',
            'data' => $employee
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'department' => 'required|string',
            'position' => 'required|string',
            'email' => 'required|email|unique:employees,email,'.$id,
            'contact_number' => 'nullable|string',
            'date_separated' => 'nullable|date',
            'employment_status' => 'required|string',
            'location' => 'nullable|string',
            'accountability_form' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120'
        ]);

        if ($request->hasFile('accountability_form')) {
            $path = $request->file('accountability_form')->store('accountability_forms', 'public');
            $data['accountability_form'] = $path;
        }

        $employee = $this->employeeService->updateEmployee($id, $data);

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $this->employeeService->deleteEmployee($id);

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully!'
        ]);
    }

    public function printAccountability(\App\Models\Employee $employee)
    {
        $employee->load('assets.category');
        return view('employees.print-accountability', compact('employee'));
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="employee_import_template.csv"',
        ];

        $columns = ['first_name', 'middle_name', 'last_name', 'email', 'department', 'position', 'contact_number', 'date_hired', 'employment_status', 'location'];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['John', 'A', 'Doe', 'johndoe@example.com', 'IT Department', 'Developer', '09123456789', '2026-01-01', 'Active', 'Main Office']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:5120'
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $importedCount = 0;

        if ($extension === 'xlsx') {
            if ($xlsx = \Shuchkin\SimpleXLSX::parse($file->getPathname())) {
                $rows = $xlsx->rows();
                if (count($rows) > 1) {
                    array_shift($rows); // Remove header
                    foreach ($rows as $row) {
                        if (empty($row[0]) || empty($row[2]) || empty($row[3])) continue; // Skip missing required
                        
                        $data = [
                            'first_name' => $row[0] ?? '',
                            'middle_name' => $row[1] ?? '',
                            'last_name' => $row[2] ?? '',
                            'email' => $row[3] ?? '',
                            'department' => $row[4] ?? 'N/A',
                            'position' => $row[5] ?? 'N/A',
                            'contact_number' => $row[6] ?? '',
                            'date_hired' => (!empty($row[7]) && strtotime($row[7])) ? date('Y-m-d', strtotime($row[7])) : null,
                            'employment_status' => $row[8] ?? 'Active',
                            'location' => $row[9] ?? '',
                        ];
                        
                        if (!\App\Models\Employee::where('email', $data['email'])->exists()) {
                            $this->employeeService->createEmployee($data);
                            $importedCount++;
                        }
                    }
                }
            }
        } else {
            // Handle CSV
            if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                fgetcsv($handle); // Remove header
                while (($row = fgetcsv($handle)) !== false) {
                    if (empty($row[0]) || empty($row[2]) || empty($row[3])) continue;
                    
                    $data = [
                        'first_name' => $row[0] ?? '',
                        'middle_name' => $row[1] ?? '',
                        'last_name' => $row[2] ?? '',
                        'email' => $row[3] ?? '',
                        'department' => $row[4] ?? 'N/A',
                        'position' => $row[5] ?? 'N/A',
                        'contact_number' => $row[6] ?? '',
                        'date_hired' => (!empty($row[7]) && strtotime($row[7])) ? date('Y-m-d', strtotime($row[7])) : null,
                        'employment_status' => $row[8] ?? 'Active',
                        'location' => $row[9] ?? '',
                    ];
                    
                    if (!\App\Models\Employee::where('email', $data['email'])->exists()) {
                        $this->employeeService->createEmployee($data);
                        $importedCount++;
                    }
                }
                fclose($handle);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully imported {$importedCount} employees."
        ]);
    }

    public function history($id)
    {
        $history = \App\Models\AssetHistory::with('performer')
            ->where(function($q) use ($id) {
                $q->where('new_value', (string)$id)
                  ->orWhere('previous_value', (string)$id);
            })
            ->whereIn('action_type', ['Assigned', 'Unassigned'])
            ->latest()
            ->get();
            
        return response()->json($history);
    }
}
