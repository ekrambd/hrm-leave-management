<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_id',
        'type',
        'ai_review',
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
