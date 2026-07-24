<?php

namespace App\Services;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;


class DesignationService
{
	protected $departmentRepository;

	public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }


    public function index($perPage)
    {
        return $this->departmentRepository->getAll($perPage);
    }


    public function store($request)
    {
        return $this->departmentRepository->create([
            'user_id'         => user()->id,
            'department_name' => $request->department_name
        ]);
    }

    public function update($request, $department)
    {
        return $this->departmentRepository->update($department, [
            'department_name' => $request->department_name
        ]);
    }

    public function destroy($category)
    {
        return $this->departmentRepository->delete($category);
    }

}