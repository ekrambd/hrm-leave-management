<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
use App\Services\LeaveService;
use DataTables;
use DB;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->middleware('auth_check');
        $this->leaveService = $leaveService;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $leaves = $this->leaveService->index($request)->where('employee_id',user()->employee->id);
            return DataTables::of($leaves)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn .= '&nbsp;';
                    $btn .= ' <a href="' . route('leaves.show', $row->id) . '" class="btn btn-primary btn-sm action-button edit-product-leave"><i class="fa fa-eye"></i></a>';
                    $btn .= '&nbsp;';
                    $btn .= ' <button type="button" class="btn btn-danger btn-sm delete-leave action-button" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action']) 
                ->make(true);
        }
        return view('leaves.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leaves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeaveRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $leave = $this->leaveService->store($request);
            $notification = array(
                'messege'=> "Successfully the leave's status has been updated",
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
    public function show(Leave $leave)
    {
       $leave->load([
            'employee.department',
            'employee.designation'
        ]);
        return view('leaves.show',compact('leave'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        DB::beginTransaction();
        try
        {
            $leave = $this->employeeService->statusUpdate($request,$leave);
            $notification = array(
                'messege'=> "Successfully the leave's status has been updated",
                'alert-type'=> 'success'
            );
            DB::commit();
            return redirect('/leaves')->with($notification);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
