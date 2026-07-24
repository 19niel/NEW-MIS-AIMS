<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function getAll()
    {
        return Employee::withCount('assets')->latest()->get();
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function find($id)
    {
        return Employee::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $employee = $this->find($id);
        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        $employee = $this->find($id);
        return $employee->delete();
    }
}
