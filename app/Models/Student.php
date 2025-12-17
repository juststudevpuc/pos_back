<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Student extends Model
{
    //
    protected $connection = 'mongodb';
    protected $table = 'students';
    protected $fillable = [
        'student_id',
        'name',
        'age',
        'gender',
        'major',
        'disabled',

    ];
}
