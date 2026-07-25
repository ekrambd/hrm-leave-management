<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DesignationService;
use App\Models\Department; 
use App\Services\LeaveService;

class AjaxController extends Controller
{
    protected $designationService;
    protected $leaveService;
    public function __construct(
        DesignationService $designationService,
        LeaveService $leaveService
    )
    {
        $this->designationService = $designationService;
        $this->leaveService = $leaveService;
    }

    public function designationsByDepartment(Request $request)
    {    
        try
        {
            $query = $this->designationService->index($request);

            if($request->department_id != 'all_department')
            {
                $query->where('department_id',$request->department_id);
            }    

            $data = $query->get();

            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }


    public function notificationRead($id)
    {
        try
        {
            $notification = $this->leaveService->notificationRead($id);
            $redirectURL = url('/dashboard');
            if($notification)
            {
                $redirectURL = $notification->data['url'];
            }
            return redirect($redirectURL);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

}
