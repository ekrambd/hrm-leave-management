<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Services\DepartmentService;
use DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->middleware('auth_check');
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $departments = $this->departmentService->index($request);
            return DataTables::of($departments)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn .= ' <a href="' . route('departments.show', $row->id) . '" class="btn btn-primary btn-sm action-button edit-product-department"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;';
                    $btn .= ' <button type="button" class="btn btn-danger btn-sm delete-department action-button" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action']) 
                ->make(true);
        }
        return view('departments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        try
        {
            $department = $this->departmentService->store($request);
            $notification = array(
                'messege'=> "Successfully a department has been added",
                'alert-type'=> 'success'
            );

            return redirect()->back()->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.edit',compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        try
        {
            $department = $this->departmentService->update($request,$department);
            $notification = array(
                'messege'=> "Successfully the department has been updated",
                'alert-type'=> 'success'
            );

            return redirect('/departments')->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        try
        {
            $department = $this->departmentService->destroy($department);
            return response()->json(['status'=>true, 'message'=>'Successfully the department has been deleted']);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
