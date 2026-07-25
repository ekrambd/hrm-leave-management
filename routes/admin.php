<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;

Route::group(['middleware' => 'prevent-back-history'],function(){
	//departments
	   Route::get('departments/create', [DepartmentController::class, 'create'])->name('departments.create');
	   Route::get('departments', [DepartmentController::class, 'index'])->name('departments.index');
		Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
		Route::get('departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
		Route::patch('departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
		Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.delete');
	//designations
	   Route::get('designations/create', [DesignationController::class, 'create'])->name('designations.create');
	   Route::get('designations', [DesignationController::class, 'index'])->name('designations.index');
		Route::post('designations', [DesignationController::class, 'store'])->name('designations.store');
		Route::get('designations/{designation}', [DesignationController::class, 'show'])->name('designations.show');
		Route::patch('designations/{designation}', [DesignationController::class, 'update'])->name('designations.update');
		Route::delete('designations/{designation}', [DesignationController::class, 'destroy'])->name('designations.delete');

	//employees
		Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
	   Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
		Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
		Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
		Route::patch('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
		Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.delete');

	//leave requests
	   Route::get('/leave-requests', [LeaveController::class, 'leaveRequests'])->name('leaves.requests');
});