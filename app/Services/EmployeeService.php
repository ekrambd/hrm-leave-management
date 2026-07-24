<?php

namespace App\Services;

use App\Repositories\Interfaces\EmployeeRepositoryInterface;


class EmployeeService
{
	protected $employeeRepository;

	public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


    public function index($perPage)
    {
        return $this->employeeRepository->getAll($perPage);
    }


    public function store($request)
    {   

        if ($request->file('image')) {
            $file = $request->file('image');
            $name = time() . user()->id . $file->getClientOriginalName();
            $file->move(public_path() . '/uploads/employees/', $name);
            $path = 'uploads/employees/' . $name;
        }else{
            $path = NULL;
        }

        return $this->employeeRepository->create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'image'          => $path,
            'department_id'  => $request->department_id,
            'designation_id' => $request->designation_id,
            'employee_code'  => $request->employee_code,
            'sick_leave'     => $request->sick_leave,
            'paid_leave'     => $request->paid_leave,
            'casual_leave'   => $request->casual_leave,
            'password'       => bcrypt($request->password),
            'added_by'       => user()->id
        ]);
    }

    public function update($request, $employee)
    {
        if ($request->file('image')) {
            $file = $request->file('image');
            $name = time() . user()->id . $file->getClientOriginalName();    
            $file->move(public_path() . '/uploads/employees/', $name);
            if($employee->user->image != 'defaults/profile.png')
            {
                unlink(public_path($employee->user->image));
            }
            $path = 'uploads/employees/' . $name;
        }else{
            $path = $employee->user->image;
        }

        return $this->employeeRepository->update($employee,[
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'image'          => $path,
            'department_id'  => $request->department_id,
            'designation_id' => $request->designation_id,
            'employee_code'  => $request->employee_code,
            'sick_leave'     => $request->sick_leave,
            'paid_leave'     => $request->paid_leave,
            'casual_leave'   => $request->casual_leave,
        ]);
    }

    public function destroy($employee)
    {   
        if($employee->user->image != 'defaults/profile.png')
        {
            unlink(public_path($employee->user->image));
        }
        return $this->employeeRepository->delete($employee);
    }

}