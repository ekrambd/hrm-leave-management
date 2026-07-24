<?php

namespace App\Repositories;

use App\Models\Designation;
use App\Repositories\Interfaces\DesignationRepositoryInterface;

class DesignationRepository implements DesignationRepositoryInterface
{
	public function getAll($request)
    {
        $query = Designation::query();
        return $query;
    }

    public function create(array $data)
    {
        return Designation::create($data);
    }

    public function update($designation, array $data)
    {
        $designation->update($data);

        return $designation->fresh();
    }

    public function delete($designation)
    {    
        return $designation->delete();
    }
}