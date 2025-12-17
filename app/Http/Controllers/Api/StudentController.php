<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    //
    public function index(){
        $students = Student::all();

        return [
            "data" => $students,
            "message" => "Students retrieved successfully"
        ];
    }
}
