<?php
namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function getAll($request);

    public function create(array $data);

    public function update($employee, array $data);

    public function delete($employee);
}