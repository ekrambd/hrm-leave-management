<?php

namespace App\Repositories;

use App\Models\Leave;
use App\Repositories\Interfaces\LeaveRepositoryInterface;
use App\Notifications\LeaveRequestNotification;
use App\Models\User;
use Illuminate\Support\Facades\Http;

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
        if ($leave) {

            $admin = admin();

            $admin->notify(
                new LeaveRequestNotification(
                    'A New Leave Request',
                    'A New Leave Request From an Employee',
                    $leave->id
                )
            );

            // Socket Notification
            Http::post(config('services.socket.url').'/leave-request', [
                'admin_id' => $admin->id,
                'payload' => [
                    'leave_id'      => $leave->id,
                    'employee_name' => $leave->employee->user->name,
                    'title'         => 'A New Leave Request',
                    'message'       => 'A New Leave Request From an Employee',
                    'created_at'    => now()->diffForHumans(),
                    'notification_id' => $admin->fresh()->unreadNotifications()->latest()->first()?->id,
                ]
            ]);
        }
    }

    public function statusUpdate($leave, $employee, array $data)
    {   
    	$leave->status = $data['status'];
        $leave->type = $data['type'];
        $leave->leave_review = $data['leave_review'];
        $leave->update();
        
        $user = $employee->user;

        $user->notify(
            new LeaveRequestNotification(
                "#{$leave->id} has been {$leave->status}",
                "Leave Request Response Alert!",
                $leave->id
            )
        );

        // Socket Notification
        Http::post(config('services.socket.url').'/leave-status-update', [

            'user_id' => $user->id,

            'payload' => [
                'leave_id' => $leave->id,
                'employee_name' => $leave->employee->user->name,
                'title' => 'Leave Request Response',
                'message' => 'Leave Request Response From Admin',
                'created_at' => now()->diffForHumans(),
                'notification_id' => $user->fresh()
                    ->unreadNotifications()
                    ->latest()
                    ->first()?->id,
            ]

        ]);
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