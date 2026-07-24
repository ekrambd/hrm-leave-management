<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DesignationRepository implements DepartmentRepositoryInterface
{
	public function getAll($request)
    {
        $query = Department::query();

        if ($request->filled('search')) {
            $query->where('department_name', 'like', '%' . $request->search . '%');
        }

        return $query
            ->latest()
            ->paginate($request->get('per_page', 10));
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