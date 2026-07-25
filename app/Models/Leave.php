<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'leave_reason',
        'leave_review',
        'from_date',
        'issue_date',
        'to_date',
        'leave_duration',
        'result_date',
        'type',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    } 
}
