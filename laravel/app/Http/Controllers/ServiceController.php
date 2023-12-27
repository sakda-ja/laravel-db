<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

class ServiceController extends Controller
{

    public function index()
    {
           $services = Service::paginate(5); //ดึงข้อมูลมาแสดง แบบ Eloquen
            return view('admin.service.index' ,compact('services') ); //path เข้าถึง index.blade.php
    }




    public function store( Request $request)
    {
        //--------------------ตรวจสอบ ดักแจ้งเตือนฟอร์ม---------------------------------------------------------
        $request->validate
        (
            [
                'service_name'=>'required|unique:services|max:255',
                'service_image'=>'required|mimes:jpg,jpeg,png'
            ],

            [
                'service_name.required' => "กรุณากรอกชื่อบริการด้วยครับ" ,
                'service_name.max' => "ห้ามป้อนข้อความเกิน 255 ตัวอักษร",
                'service_name.unique' => "มีข้อมูลนี้แล้วในฐานข้อมูล",
                'service_image.required' => "กรุณาใส่ภาพประกอบด้วยครับ"

            ]
        );

        //-----------------------------------เข้ารหัส---------------------------------------------------------
        $service_image = $request->file('service_image'); //เข้ารหัส
        $name_gen = hexdec(uniqid()); //เปลี่ยนชื่อรูปภาพสุ่มแปลงเป็นตัวเลขที่ไม่ซ้ำ
        $img_ext = strtolower($service_image->getClientOriginalExtension()); //หั่นเอาเฉพาะนามสกุลมาเก็บ**เป็นตัวพิมพ์เล็ก
        $img_name = $name_gen .   '.'    .$img_ext; //รวมชื่อภาพที่สุ่มได้เป็นตัวเลข+นามสกุลไฟล์เช่น 10101010.jpg

        //---------------------------อัปโหลดลงฐานข้อมูล---------------------------------------------------------
        $upload_location = 'image/services/'; //ที่เก็บ
        $full_path = $upload_location.$img_name; //เริ่มเก็บประมวลผลที่เซิร์ฟเวอร์

        //สั่งบันทึกเก็บลงในคอลัม
        Service::insert([
            'service_name' => $request->service_name,
            'service_image' =>$full_path,
            'created_at' =>Carbon::now() // ต้อง import Class ด้วย
        ]);
        $service_image->move($upload_location , $img_name); //อัปโหลดย้ายไฟล์เก็บ
        return redirect()->back()->with('success' , "บันทึกข้อมูลเรียบร้อย");
    }

}
