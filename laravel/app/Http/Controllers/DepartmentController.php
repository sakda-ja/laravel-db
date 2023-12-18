<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use App\Models\Department;

use Illuminate\Support\Facades\Auth;



class DepartmentController extends Controller
{

    public function index()
    {
        return view('admin.department.index'); //path เข้าถึง index.blade.php
    }

    public function store( Request $request)
    {
        //ตรวจสอบข้อมูล
        $request->validate
        (
            [
                'department_name'=>'required|unique:departments|max:255'
            ],

            [
                'department_name.required' => "กรุณากรอกชื่อแผนก" ,
                'department_name.max' => "ห้ามป้อนข้อความเกิน 255 ตัวอักษร",
                'department_name.unique' => "มีข้อมูลนี้แล้ว"
            ]
        );

        //บันทึก
        $department = new Department;
        $department->department_name = $request->department_name;
        $department->user_id = Auth::user()->id;
        $department->save();
        return redirect()->back()->with('success' , 'บันทึกข้อมูลเรียบร้อย');
    }

}
