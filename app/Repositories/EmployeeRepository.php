<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAll($request)
    {
        $query = Employee::with(['user','department','designation']);

        // if ($request->filled('search')) {

        //     $search = $request->search;

        //     $query->where('employee_code', 'like', "%{$search}%")
        //           ->orWhereHas('user', function ($q) use ($search) {
        //                 $q->where('name', 'like', "%{$search}%")
        //                   ->orWhere('email', 'like', "%{$search}%")
        //                   ->orWhere('phone', 'like', "%{$search}%");
        //           });
        // }

        // // Department Filter
        // if ($request->filled('department_id')) {
        //     $query->where('department_id', $request->department_id);
        // }

        // // Designation Filter
        // if ($request->filled('designation_id')) {
        //     $query->where('designation_id', $request->designation_id);
        // }

        return $query;
    }

    public function create(array $data)
    {
        $user = User::create([
            'role_id'  => 2,
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => $data['password'],
            'image'    => $data['image'],
        ]);

        return Employee::create([
            'user_id'        => $user->id,
            'department_id'  => $data['department_id'],
            'designation_id' => $data['designation_id'],
            'employee_code'  => $data['employee_code'],
            'sick_leave'     => $data['sick_leave'],
            'paid_leave'     => $data['paid_leave'],
            'casual_leave'   => $data['casual_leave'],
            'added_by'       => $data['added_by'],
        ]);
    }

    public function update($employee, array $data)
    {
        $employee->user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'image' => $data['image'],
        ]);

        $employee->update([
            'department_id'  => $data['department_id'],
            'designation_id' => $data['designation_id'],
            'employee_code'  => $data['employee_code'],
            'sick_leave'     => $data['sick_leave'],
            'paid_leave'     => $data['paid_leave'],
            'casual_leave'   => $data['casual_leave'],
        ]);

        return $employee->fresh(['user', 'department', 'designation']);
    }

    public function delete($employee)
    {
        $user = $employee->user;

        $employee->delete();

        if ($user) {
            $user->delete();
        }

        return true;
    }
}