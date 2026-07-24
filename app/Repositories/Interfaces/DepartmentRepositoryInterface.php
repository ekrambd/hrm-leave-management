<?php

namespace App\Repositories\Interfaces;

interface DepartmentRepositoryInterface
{
    public function getAll($request);

    public function create(array $data);

    public function update($department, array $data);

    public function delete($department);
}