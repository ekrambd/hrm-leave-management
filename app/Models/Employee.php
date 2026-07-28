<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $appends = ['total_leave_balance'];

    protected $fillable = [
        'user_id',
        'department_id',
        'designation_id',
        'employee_code',
        'sick_leave',
        'paid_leave',
        'casual_leave',
        'added_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function getTotalLeaveBalanceAttribute(): int
    {
        return ($this->sick_leave ?? 0)
            + ($this->paid_leave ?? 0)
            + ($this->casual_leave ?? 0);
    }
}
