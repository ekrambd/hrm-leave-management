<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function Dashboard(Request $request)
    {   
        $today = Carbon::today()->toDateString();
        if(user()->role_id == 1)
        {   
            $summary = leaveService($request)->index($request)->selectRaw("
            SUM(CASE WHEN DATE(issue_date) = ? THEN 1 ELSE 0 END) as today_leave_requests,
            SUM(CASE WHEN DATE(issue_date) = ? AND status = 'pending' THEN 1 ELSE 0 END) as today_pending_leave_requests,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as total_approved_requests,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as total_rejected_requests
        ", [$today, $today])->first();
            return view('layouts.admin_app',compact('summary'));
        }
        $summary = leaveService($request)->index($request)->selectRaw("
            COUNT(*) as my_total_leave_requests,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as my_total_pending_requests,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as my_total_approved_requests,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as my_total_rejected_requests
        ")
        ->where('employee_id', user()->employee->id)
        ->first(); 
        return view('layouts.user_app',compact('summary'));
    }
}
