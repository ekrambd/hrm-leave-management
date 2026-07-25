<?php

namespace App\Repositories;

use App\Models\Leave;
use App\Repositories\Interfaces\LeaveRepositoryInterface;
use App\Notifications\LeaveRequestNotification;
use App\Models\User;

class LeaveRepository implements LeaveRepositoryInterface
{
	public function getAll($request)
    {
        $query = Leave::query();
        return $query;
    }

    public function create(array $data)
    {
        $leave = Leave::create($data);
        if($leave){
            $admin = User::where('role_id',1)->first();
            $admin->notify(
                new LeaveRequestNotification(
                    'A New Leave Request',
                    'A New Leave Request From an Employee',
                    $leave->id
                )
            ); 
        }
    }

    public function statusUpdate($leave, array $data)
    {   
    	$leave->status = $data['status'];
        $leave->update();
        $employee = employeeDetails($leave->employee_id);
        $user = $employee->user();
        $admin->notify(
            new LeaveRequestNotification(
                "#{$leave->id} has been {$leave->status}",
                "Leave Request Response Alert!",
                $leave->id
            )
        );
        return $leave->fresh(); 
    }

    public function notificationRead($id)
    {
        $notification = user()->notifications()->find($id);

        $notification->markAsRead();

        return $notification->fresh();
    }

    public function delete($leave)
    {    
        return $leave->delete();
    }
}