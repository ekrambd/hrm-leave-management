<?php
use App\Models\Department;
use App\Models\Designation;
use App\Services\EmployeeService;
use App\Models\User;


if (!function_exists('employeeService')) {

    function employeeService()
    {
        return app(EmployeeService::class);
    }

}

function user()
{
	$user = auth()->user();
	return $user;
}

function admin()
{
    $user = User::where('role_id',1)->first();
    return $user;
}

function departments()
{
	$departments = Department::get();
	return $departments;
}

function designations()
{
	$designations = Designation::get();
	return $designations;
}

function employeeDetails($request,$id)
{
	$employee = employeeService()->index($request)->where('id',$id)->first();
	return $employee;
}

function unReadNotifications()
{
    return user()
        ->unreadNotifications()
        ->take(15)
        ->get();
}

function leaveDuration($from_date, $to_date)
{
    $start = strtotime($from_date);
    $end = strtotime($to_date);

    $days = (($end - $start) / (60 * 60 * 24)) + 1;

    return $days;
}