<?php

namespace App\Services;

class ToolService
{
	public function getEmployeeLeaveStatistics(array $filters): array
    {
        $query = Leave::query();

        /*
        |--------------------------------------------------------------------------
        | Employee ID
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        /*
        |--------------------------------------------------------------------------
        | Employee Code
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['employee_code'])) {

            $employee = Employee::where(
                'employee_code',
                $filters['employee_code']
            )->first();

            if (!$employee) {
                return [
                    "success" => false,
                    "message" => "Employee not found."
                ];
            }

            $query->where('employee_id', $employee->id);
        }

        /*
        |--------------------------------------------------------------------------
        | Leave Status
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        /*
        |--------------------------------------------------------------------------
        | Leave Type
        |--------------------------------------------------------------------------
        */

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range (Overlap)
        |--------------------------------------------------------------------------
        */

        if (
            !empty($filters['from_date']) &&
            !empty($filters['to_date'])
        ) {

            $query->where(function ($q) use ($filters) {

                $q->where('from_date', '<=', $filters['to_date'])
                  ->where('to_date', '>=', $filters['from_date']);

            });

        }

        return [

            "success" => true,

            "total_requests" => (clone $query)->count(),

            "approved_requests" => (clone $query)
                ->where('status', 'approved')
                ->count(),

            "pending_requests" => (clone $query)
                ->where('status', 'pending')
                ->count(),

            "rejected_requests" => (clone $query)
                ->where('status', 'rejected')
                ->count(),

            "total_leave_days" => (clone $query)
                ->sum('leave_duration'),

        ];
    }
}