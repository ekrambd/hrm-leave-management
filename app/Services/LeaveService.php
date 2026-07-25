<?php

namespace App\Services;

use App\Repositories\Interfaces\LeaveRepositoryInterface;

class LeaveService
{
	protected $leaveRepository;

	public function __construct(LeaveRepositoryInterface $leaveRepository)
    {
        $this->leaveRepository = $leaveRepository;
    }


    public function index($request)
    {
        return $this->leaveRepository->getAll($request);
    }


    public function store($request)
    {
        return $this->leaveRepository->create([
            'employee_id'       => user()->employee->id,
            'leave_reason'      => $request->leave_reason,
            'leave_review'      => $request->leave_review,
            'issue_date'        => date('Y-m-d'),
            'from_date'         => $request->from_date,
            'to_date'           => $request->to_date,
            'leave_duration'    => leaveDuration($request->from_date,$request->to_date),
            'result_date'       => $request->result_date,
            'type'              => $request->type,
            'status'            => $request->has('status') ? $request->status : 'pending',
        ]);
    }

    public function statusUpdate($request,$leave)
    {
        return $this->leaveRepository->statusUpdate($leave,[
            'status' => $request->status,
        ]); 
    }

    public function notificationRead($id)
    {
        return $this->leaveRepository->notificationRead($id);
    } 
}