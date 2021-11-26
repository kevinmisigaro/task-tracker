<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    use HasFactory;

    protected $table = 'department_users';

    protected $fillable = [
        'user_id', 'department_id'
    ];

}
