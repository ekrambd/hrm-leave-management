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

    public function designationsByDepartment(Request $request)
    {    
        

        $query = $this->designationService->index($request);

        if($request->department_id != 'all_department')
        {
            $query->where('department_id',$request->department_id);
        }    

        $data = $query->get();

        return response()->json($data);

       
        // return response()->json(
        //     $department->designations()->select('id','designation_name')->get()
        // );
    }

}
