<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;




class DepartmentController extends Controller
{

    public function index()
    {
        return view('admin.department.index'); //path เข้าถึง index.blade.php
    }

    public function store( Request $request)
    {

        $request->validate(
            [
                'department_name'=>'required|unique:departments|max:255'

            ],
            [
                'department_name.required' => "กรุณากรอกชื่อแผนก" ,
                'department_name.max' => "ห้ามป้อนข้อความเกิน 255 ตัวอักษร"
            ]
        );
    }

}
