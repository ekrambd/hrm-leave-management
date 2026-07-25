<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use DataTables;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->middleware('auth_check');
        $this->employeeService = $employeeService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $employees = $this->employeeService->index($request)->latest();

            return DataTables::of($employees)
                ->addIndexColumn()

                ->addColumn('image', function ($row) {

                    return '<img src="' . asset($row->user->image) . '" width="50" height="50" class="img-thumbnail">';
                })

                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })

                ->addColumn('email', function ($row) {
                    return $row->user->email;
                })

                ->addColumn('phone', function ($row) {
                    return $row->user->phone;
                })

                ->addColumn('department', function ($row) {
                    return $row->department->department_name;
                })

                ->addColumn('designation', function ($row) {
                    return $row->designation->designation_name;
                })

                ->addColumn('action', function ($row) {

                    $btn = '';
                    $btn .= '&nbsp;';
                    $btn .= '<a href="' . route('employees.show', $row->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';

                    $btn .= '&nbsp;';

                    $btn .= '<button type="button"
                                class="btn btn-danger btn-sm delete-employee mx-2 my-2"
                                data-id="' . $row->id . '">
                                <i class="fa fa-trash"></i>
                              </button>';

                    return $btn;
                })

                ->rawColumns(['image', 'action'])

                ->make(true);
        }

        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $employee = $this->employeeService->store($request);
            $notification = array(
                'messege'=> "Successfully an employee has been added",
                'alert-type'=> 'success'
            );
            DB::commit();
            return redirect()->back()->with($notification);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['user','department','designation']);
        return view('employees.edit',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();
        try
        {
            $employee = $this->employeeService->update($request,$employee);
            $notification = array(
                'messege'=> "Successfully the employee has been updated",
                'alert-type'=> 'success'
            );
            DB::commit();
            return redirect('/employees')->with($notification);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try
        {
            $employee = $this->employeeService->destroy($employee);
            DB::commit();
            return response()->json(['status'=>true, 'message'=>'Successfully the employee has been deleted']);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
