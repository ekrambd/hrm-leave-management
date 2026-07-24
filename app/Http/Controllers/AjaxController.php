<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DesignationService;
use App\Models\Department;

class AjaxController extends Controller
{
    protected $designationService;

    public function __construct(
        DesignationService $designationService
    )
    {
        $this->designationService = $designationService;
    }

    public function designations(Department $department)
    {
        return response()->json(
            $department->designations()->select('id','designation_name')->get()
        );
    }

}
