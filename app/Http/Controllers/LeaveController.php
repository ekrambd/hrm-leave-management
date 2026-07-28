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


    public function leaveRequests(Request $request)
    {
        if($request->ajax()){
            $query = $this->leaveService->index($request);

            if ($request->filled('search')) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    // Leave ID Search
                    $q->where('leaves.id', 'like', "%{$search}%")

                      // Employee Related Search
                      ->orWhereHas('employee', function ($employee) use ($search) {

                          $employee->where('employee_code', 'like', "%{$search}%")
                                   ->orWhereHas('user', function ($user) use ($search) {

                                       $user->where('name', 'like', "%{$search}%")
                                            ->orWhere('email', 'like', "%{$search}%")
                                            ->orWhere('phone', 'like', "%{$search}%");

                                   })
                                   ->orWhereHas('department', function ($department) use ($search) {

                                       $department->where('department_name', 'like', "%{$search}%");

                                   })
                                   ->orWhereHas('designation', function ($designation) use ($search) {

                                       $designation->where('designation_name', 'like', "%{$search}%");

                                   });

                      });

                });
            }

            $leaves = $query->latest();

            return DataTables::of($leaves)
                ->addIndexColumn()

                ->addColumn('employee_name', function ($row) {
                    return $row->employee->user->name;
                })

                ->addColumn('employee_code', function ($row) {
                    return $row->employee->employee_code;
                })

                ->addColumn('department', function ($row) {
                    return $row->employee->department->department_name;
                })

                ->addColumn('designation', function ($row) {
                    return $row->employee->designation->designation_name;
                })



                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn .= '&nbsp;';
                    $btn .= ' <a href="' . route('leaves.show', $row->id) . '" class="btn btn-primary btn-sm action-button edit-product-leave"><i class="fa fa-eye"></i></a>';
                    $btn .= '&nbsp;';
                    $btn .= ' <a href="' . route('leaves.show', $row->id) . '" class="btn btn-danger btn-sm action-button" data-id="' . $row->id . '"><i class="nav-icon bi bi-table"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','employee_name','employee_code','department','designation','']) 
                ->make(true);
        }
        return view('leaves.leave_requests'); 
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
       if (user()->role_id == 1) {
            return view('leaves.admin_show', compact('leave'));
        }

        return view('leaves.user_show', compact('leave'));
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
    public function update(LeaveRequest $request, Leave $leave)
    {
        try
        {
            $leave = $this->leaveService->statusUpdate($request,$leave);
            $notification = array(
                'messege'=> "Successfully updated",
                'alert-type'=> 'success'
            );
            return redirect('/leave-requests')->with($notification);
        }catch(\Exception $e){
            \Log::error($e);
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        try
        {
            $leave = $this->leaveService->destroy($leave);
            if($leave){
                return response()->json(['status'=>true, 'message'=>'Successfully the leave has been deleted']);
            }
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
