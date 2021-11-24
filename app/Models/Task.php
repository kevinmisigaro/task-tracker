<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name', 'user_id', 'report', 'start_date', 'end_date',
        'comment', 'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
