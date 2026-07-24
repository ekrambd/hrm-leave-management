<?php

namespace App\Repositories;

use App\Models\Designation;
use App\Repositories\Interfaces\DesignationRepositoryInterface;

class DesignationRepository implements DesignationRepositoryInterface
{
	public function getAll($request)
    {
        $query = Designation::query();

        if ($request->filled('search')) {
            $query->where('designation_name', 'like', '%' . $request->search . '%');
        }

        return $query
            ->latest()
            ->paginate($request->get('per_page', 10));
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