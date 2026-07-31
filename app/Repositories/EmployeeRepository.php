<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAll($request)
    {
        $query = Employee::with(['user','department','designation']);

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where('employee_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('phone', 'like', "%{$search}%");
                  });
        }

        // Department Filter
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Designation Filter
        if ($request->filled('designation_id')) {
            $query->where('designation_id', $request->designation_id);
        }

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



    public function generate(Collection $leaves): array
    {
        return [

            'current_month' => $this->summary(
                $leaves,
                now()->startOfMonth(),
                now()->endOfMonth()
            ),

            'last_month' => $this->summary(
                $leaves,
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ),

            'current_year' => $this->summary(
                $leaves,
                now()->startOfYear(),
                now()->endOfYear()
            ),

            'last_year' => $this->summary(
                $leaves,
                now()->subYear()->startOfYear(),
                now()->subYear()->endOfYear()
            ),

            'last_six_month' => $this->summary(
                $leaves,
                now()->subMonths(5)->startOfMonth(),
                now()->endOfMonth()
            ),

        ];
    }


    private function summary(
        Collection $leaves,
        Carbon $start,
        Carbon $end
    ): array {

        $totalRequests = 0;
        $pendingRequests = 0;
        $approvedRequests = 0;
        $totalLeaveDays = 0;


        foreach ($leaves as $leave) {


            $from = Carbon::parse($leave->from_date);
            $to   = Carbon::parse($leave->to_date);


            // Check date overlap
            if ($from->gt($end) || $to->lt($start)) {
                continue;
            }


            $totalRequests++;


            if ($leave->status == 'pending') {
                $pendingRequests++;
            }


            if ($leave->status == 'approved') {
                $approvedRequests++;
            }


            // Calculate actual days inside this period
            $actualStart = $from->greaterThan($start)
                ? $from
                : $start;


            $actualEnd = $to->lessThan($end)
                ? $to
                : $end;


            $totalLeaveDays += $actualStart->diffInDays($actualEnd) + 1;

        }


        return [

            'total_requests' => $totalRequests,

            'pending_requests' => $pendingRequests,

            'approved_requests' => $approvedRequests,

            'total_leave_days' => $totalLeaveDays,

        ];
    }

    public function context($employee_id, $leave = null)
    {   
        $employee = Employee::findorfail($employee_id);
        $employee = employeeUser($employee);

        
        $leaves = Leave::where('employee_id', $employee->id)
            ->select([
                'id',
                'type',
                'from_date',
                'to_date',
                'leave_duration',
                'status',
                'leave_reason'
            ])
            ->get();


        $leaveRecordSummary = $this->generate($leaves);

        return [

            "id" => $employee->id,
            "designation_id" => $employee->designation_id,
            "designation" => $employee->designation->designation_name,
            "department_id" => $employee->department_id,
            "department" => $employee->department->department_name,
            "employee_name" => $employee->user->name,
            "employee_phone" => $employee->user->phone,
            "employee_email" => $employee->user->email,
            "employee_code" => $employee->employee_code,

            "leave_balance" => [
                "total" => $employee->sick_leave + $employee->paid_leave + $employee->casual_leave,
                "sick" => $employee->sick_leave,
                "paid" => $employee->paid_leave,
                "casual" => $employee->casual_leave,
                "unit" => "days"
            ],

            "leave_record_summary" => $leaveRecordSummary,

            "current_request" => $leave

        ];
    }
}