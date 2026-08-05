<?php
use App\Models\Department;
use App\Models\Designation;
use App\Services\EmployeeService;
use App\Services\LeaveService;
use App\Services\DepartmentService;
use App\Models\User;


if (!function_exists('employeeService')) {

    function employeeService()
    {
        return app(EmployeeService::class);
    }

}


if (!function_exists('leaveService')) {

    function leaveService()
    {
        return app(LeaveService::class);
    }

}



if (!function_exists('departmentService')) {

    function departmentService()
    {
        return app(DepartmentService::class);
    }

}


function user()
{
	$user = auth()->user();
	return $user;
}

function employeeUser($employee)
{
    $user = $employee->load(['user','designation','department']);
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


function employeeByCode($request,$employee_code)
{
    $employee = employeeService()->index($request)->where('employee_code',$employee_code)->first();
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