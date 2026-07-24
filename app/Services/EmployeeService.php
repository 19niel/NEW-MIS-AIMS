<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;

class EmployeeService
{
    public function __construct(protected EmployeeRepository $repository)
    {
    }

    public function getAllEmployees()
    {
        return $this->repository->getAll();
    }

    public function createEmployee(array $data)
    {
        return $this->repository->create($data);
    }

    public function getEmployee($id)
    {
        return $this->repository->find($id);
    }

    public function updateEmployee($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteEmployee($id)
    {
        return $this->repository->delete($id);
    }
}
