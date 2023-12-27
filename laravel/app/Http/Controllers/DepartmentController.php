<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class DepartmentController extends Controller
{

//ทำงานกับฐานข้อมูล--------------------------------------------------------------------------------
    public function index()
    {
        $departments = Department::paginate(5); //ดึงข้อมูลมาแสดง แบบ Eloquen
        $trashDepartments = Department::onlyTrashed()->paginate(3); //ดึงข้อมูลให้มาแสดงในถังขยะ
        //$departments = Department::all(); //แบบปกติ
        //$departments=DB::table ('departments')->get(); //Query Builder
        //$departments=Department::paginate(3); //Query Builder แบบเข้าไปแก้ไขใน Model
        // $departments = DB::table('departments') -> join ('users' , 'departments.user_id' , 'users.id') //join table ตารางชื่อ usersกับ ตารางชื่อ departments จับตรวจสอบ PK user_id
        //                                        -> select('departments.*' , 'users.name') // เลือกตาราง users เข้าไปเลือก คอลัม .name
        //                                        -> paginate(5);  //กำหนดแสดงจำนวน
        return view('admin.department.index' ,compact('departments','trashDepartments') ); //path เข้าถึง index.blade.php
    }



//บันทึก--------------------------------------------------------------------------------
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

        //บันทึกแบบที่ 1
        // $department = new Department;
        // $department->department_name = $request->department_name;
        // $department->user_id = Auth::user()->id;
        // $department->save();

     //Query Builder
        $data = array();
        $data ["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;

    //Query Builder
        DB::table('departments')->insert($data);
        return redirect()->back()->with('success' , 'บันทึกข้อมูลเรียบร้อย');
    }



//ดึงข้อมูลมารอแก้ไข--------------------------------------------------------------------------------
    public function edit($id)
    {
        $department = Department::find($id); //สั่งค้นหา id
        //dd($department->department_name);//Debug


         //df
        return view('admin.department.edit' , compact('department') );

    }




//แก้ไขข้อมูล--------------------------------------------------------------------------------
    public function update(Request $request , $id)
    {
        //dd($id , $request->department_name);//Debug

                //1.เขียนตรวจสอบข้อมูลดัก------------------
                $request->validate
                (
                    [
                        'department_name'=>'required|unique:departments|max:255'
                    ],

                    [
                        'department_name.required' => "ตรวจสอบว่าท่านกรอกชื่อแผนกหรือไม่ / ตรวจสอบว่าท่านได้แก้ไขหรือไม่ / ตรวจสอบว่าท่านไม่ได้กรอกข้อมูลหรือไม่" ,
                        'department_name.max' => "ห้ามป้อนข้อความเกิน 255 ตัวอักษร",
                        'department_name.unique' => "มีข้อมูลนี้แล้ว"
                    ]
                );
                //เขียนตรวจสอบข้อมูลดัก------------------



                //2.ค้นหาจาก id เพื่อมาแก้ไข
                $update = Department::find($id)->update([
                    'department_name' => $request->department_name ,
                    'user_id' => Auth::user()->id
                ]);



                //3.ส่งข้อความตอบกลับ โดยใช้ Alert 'success'
                return redirect()->route('department')->with('success' , 'อัพเดตข้อมูลเรียบร้อยแล้ว');

    }



//ลบลงถังขยะ--------------------------------------------------------------------------------
    public function softdelete($id)
    {
        //dd($id);//debug

        //1.ค้นหาและลบ
        $delete = Department::find($id) ->delete();
        //2.ลบและแจ้ง Alert 'success'
        return redirect()->back()->with('success' , 'ลบข้อมูลเรียบร้อย');

    }



//กู้คืน--------------------------------------------------------------------------------
public function restore($id)
{
    //dd($id);//debug

    //1.ค้นหาและกู้คืน
   $restore=Department::withTrashed()->find($id)->restore();
    //2.กู้และแจ้ง Alert 'success'
    return redirect()->back()->with('success' , 'กู้คืนข้อมูลสำเร็จ');

}

//ลบถาวร--------------------------------------------------------------------------------
public function delete($id)
{
    Department::onlyTrashed()->find($id)->forceDelete(); //สั่งค้นหา id และสั่งลบ
    //2.ลบและแจ้ง Alert 'success'
    return redirect()->back()->with('success' , 'ลบข้อมูลถาวรสำเร็จ');

}

//อัปโหลดไฟล์--------------------------------------------------------------------------------




}
