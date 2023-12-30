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

//ดึงข้อมูลมารอแก้ไข--------------------------------------------------------------------------------
    public function edit($id)
    {
        $service = Service::find($id); //สั่งค้นหา id service
        return view('admin.service.edit' , compact('service') );

    }

//แก้ไขข้อมูล Upload image--------------------------------------------------------------------------------
    public function update(Request $request , $id){
        //ตรวจสอบข้อมูล
        $request->validate(
            [
                'service_name'=>'required|max:255',
            ],
            [
                'service_name.required'=>"กรุณาป้อนชื่อบริการด้วยครับ",
                'service_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            ]
        );

        //เช็คอัปโหลดภาพมาหรือไม่
       $service_image = $request->file('service_image');

        //ถ้ามีการอัปโหลด จะเข้าสู่กระบวนการ if else
        if($service_image){

            //Generate ชื่อภาพ
            $name_gen=hexdec(uniqid());

            // ดึงนามสกุลไฟล์ภาพ
            $img_ext = strtolower($service_image->getClientOriginalExtension());

            //นำชื่อ นามสกุลมาต่อกัน
            $img_name = $name_gen.'.'.$img_ext;

            //ระบุ PATH เพื่ออัปโหลดภาพ
            $upload_location = 'image/services/';
            $full_path = $upload_location.$img_name;

            //อัปเดท PATH ให้เป็นภาพใหม่ที่อยู่ในฐานข้อมูล
            Service::find($id)->update([
                'service_name'=>$request->service_name,
                'service_image'=>$full_path,
            ]);

            //ลบภาพเก่าในโฟลเดอร์และอัพภาพใหม่แทนที่
            $old_image = $request->old_image; //รับมาจากฟอร์ม edit.blade.php
            unlink($old_image); //สั่งลบ
            $service_image->move($upload_location,$img_name.$old_image); //สั่งแทนที่ภาพใหม่เข้าไป

            //แจ้งเตือนอัปเดทสำเร็จ->กลับหน้าเดิม
            return redirect()->route('services')->with('success',"อัพเดตภาพเรียบร้อย");

        }else{ //หากอัปเดทแค่ชื่อภาพเข้าเงื่อนไข else นี้

            //อัพเดตชื่ออย่างเดียว
            Service::find($id)->update([
                'service_name'=>$request->service_name,
            ]);

            //แจ้งเตือนอัปเดทสำเร็จ->กลับหน้าเดิม
            return redirect()->route('services')->with('success',"อัพเดตชื่อบริการเรียบร้อย");

        }

    }


//Upload image--------------------------------------------------------------------------------
    public function store( Request $request)
    {
        //-----------ตรวจสอบ ดักแจ้งเตือนฟอร์ม------
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

        //-----------------------เข้ารหัส----------------------
        $service_image = $request->file('service_image'); //เข้ารหัส
        $name_gen = hexdec(uniqid()); //เปลี่ยนชื่อรูปภาพสุ่มแปลงเป็นตัวเลขที่ไม่ซ้ำ
        $img_ext = strtolower($service_image->getClientOriginalExtension()); //หั่นเอาเฉพาะนามสกุลมาเก็บ**เป็นตัวพิมพ์เล็ก
        $img_name = $name_gen .   '.'    .$img_ext; //รวมชื่อภาพที่สุ่มได้เป็นตัวเลข+นามสกุลไฟล์เช่น 10101010.jpg

        //--------------------อัปโหลดลงฐานข้อมูล---------------
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




    public function delete($id)
    {
        // ลบภาพในโฟลเดอร์
        $img = Service::find($id)->service_image; //ไปค้นจาก Models/Service.php เพื่อหา PATH ไปลบใน Folder
        unlink($img); //สั่งลบ

        //ลบข้อมูลชื่อภาพจากฐานข้อมูล
        $delete=Service::find($id)->delete();
        return redirect()->back()->with('success',"ลบข้อมูลเรียบร้อย");

    }

}
