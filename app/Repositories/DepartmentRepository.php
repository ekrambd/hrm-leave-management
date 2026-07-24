<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
	public function getAll($request)
    {
        $query = Department::query();
        return $query;
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function update($department, array $data)
    {
        $department->update($data);
        return $department->fresh();
    }

    public function delete($department)
    {    
        return $department->delete();
    }
}