<?php

namespace App\Services;

use App\Repositories\Interfaces\DesignationRepositoryInterface;


class DesignationService
{
	protected $designationRepository;

	public function __construct(DesignationRepositoryInterface $designationRepository)
    {
        $this->designationRepository = $designationRepository;
    }


    public function index($perPage)
    {
        return $this->designationRepository->getAll($perPage);
    }


    public function store($request)
    {
        return $this->designationRepository->create([
            'user_id'       => user()->id,
            'department_id' => $request->department_id,
            'designation_name' => $request->designation_name
        ]);
    }

    public function update($request, $designation)
    {
        return $this->designationRepository->update($designation, [
            'department_id'   => $request->department_id,
            'designation_name' => $request->designation_name
        ]);
    }

    public function destroy($designation)
    {
        return $this->designationRepository->delete($designation);
    }

}