<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assignment_id',
        'course_id',
        'answer',
        'grade',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignment()
    {
        return $this->belongsTo(Assignments::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
