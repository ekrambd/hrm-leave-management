<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AiReview;

class Leave extends Model
{
    use HasFactory;

    protected $appends = ['check_ai_review'];

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

    public function aiReview()
    {
        return $this->hasOne(Aireview::class);
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public function getCheckAiReviewAttribute()
    {
        $data = AiReview::where('leave_id',$this->id)->first();
        if($data){
            return $data;
        }
        return null;
    } 
}
