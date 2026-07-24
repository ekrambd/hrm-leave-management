<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Services\DesignationService;
use DataTables;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->middleware('auth_check');
        $this->designationService = $designationService;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $designations = $this->designationService->index($request);
            return DataTables::of($designations)
                ->addIndexColumn()


                ->addColumn('department', function ($row) {
                    return $row->department->department_name;
                })

                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn .= ' <a href="' . route('designations.show', $row->id) . '" class="btn btn-primary btn-sm action-button edit-product-designation"><i class="fa fa-edit"></i></a>';
                    $btn .= '&nbsp;';
                    $btn .= ' <button type="button" class="btn btn-danger btn-sm delete-designation action-button" data-id="' . $row->id . '"><i class="fa fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action','department']) 
                ->make(true);
        }
        return view('designations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('designations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDesignationRequest $request)
    {
        try
        {
            $designation = $this->designationService->store($request);
            $notification = array(
                'messege'=> "Successfully a designation has been added",
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
    public function show(Designation $designation)
    {   
        return view('designations.edit',compact('designation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        try
        {
            $designation = $this->designationService->update($request,$designation);
            $notification = array(
                'messege'=> "Successfully the designation has been updated",
                'alert-type'=> 'success'
            );

            return redirect('/designations')->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        try
        {
            $designation = $this->designationService->destroy($designation);
            return response()->json(['status'=>true, 'message'=>'Successfully the designation has been deleted']);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
