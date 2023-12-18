<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //import SoftDeletes


class Department extends Model
{
    use HasFactory;
    use SoftDeletes; //เรียกมาจากที่ประกาศ


    protected $fillable = [
        'user_id',
        'department_name'
    ];
}
