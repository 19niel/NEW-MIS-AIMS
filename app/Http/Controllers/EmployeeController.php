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
            'employee_number' => 'required|unique:employees',
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
}
