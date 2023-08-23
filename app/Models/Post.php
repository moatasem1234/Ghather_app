<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_text',
        'image',
        'video',
        'post_date',
        'update_date',
        'visibility'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
