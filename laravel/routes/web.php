<?php

// use App\Models\User; //ประกาศดึง Model เข้ามาทำงาน

use App\Http\Controllers\DepartmentController; //import สร้าง Route ของ Folder department
use App\Models\Service;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ServiceController;


//---------------------------------------------------------------------------------------------------------------//

//Route ของ หน้าแรก
Route::get('/', function () {
    return view('welcome');
});


//-------------------------------------------------Dashboard--------------------------------------------------------------//

//Route ของ Dashboard
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function ()
{
    Route::get('/dashboard', function ()
    {
        // $users = User::all(); //นำมากจาก Model User; ที่ประกาศ = User ตัวนี้มาจากชื่อตารางในฐานข้อมูล ใช้คำสั่งนี้ต่อเมื่อสร้างฐานข้อมูลใหม่
        $users = DB::table('users')->get(); //นำมาจาก DB;ด้านบน ใช้คำสั่งนี้กรณีมีตารางอยู่แล้ว ต้องการดึงมาใช้
        return view('dashboard' , compact('users'));
    })->name('dashboard');
});

//------------------------------------------middleware (เด้งกลับหน้า Login)--------------------------------------------------//




//Route ของ middleware เพื่อกำหนดสิทธิ์การเข้าถึง (เด้งกลับหน้า Login )
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function(){

    //Route Department CRUD ดึง เพิ่ม แก้ไข ลบชั่วคราว ลบถาวร
        Route::get('/department/all' , [DepartmentController::class , 'index'] )->name('department'); //Route ของ Folder admin/department
        Route::post('/department/add' , [DepartmentController::class , 'store'] )->name('addDepartment');  //Route ของการเพิ่มข้อมูล
        Route::get ('/department/edit/{id}' , [DepartmentController::class, 'edit'] ); //Route ของการดึงข้อมูลมารอแก้ไข
        Route::post ('/department/update/{id}' , [DepartmentController::class, 'update'] ); //Route ของการแก้ไขข้อมูล
        Route::get ('/department/softdelete/{id}' , [DepartmentController::class, 'softdelete'] ); //Route ของการลบลงถังขยะ
        Route::get ('/department/restore/{id}' , [DepartmentController::class, 'restore'] ); //Route ของการกู้คืน
        Route::get ('/department/delete/{id}' , [DepartmentController::class, 'delete'] ); //Route ลบถาวร
    //Route Service CRUD ดึง เพิ่ม แก้ไข ลบถาวร อัปโหลดภาพ
        Route::get ('/service/all' , [ServiceController::class, 'index'] )->name('services'); //Route บริการอัปโหลด
        Route::post('/service/add' , [ServiceController::class , 'store'] )->name('addService');  //Route ของการเพิ่มข้อมูล
        Route::get ('/service/edit/{id}' , [ServiceController::class, 'edit'] ); //Route ของการดึงข้อมูลมารอแก้ไข{ของอัปโหลด}
        Route::post ('/service/update/{id}' , [ServiceController::class, 'update'] ); //Route ของการแก้ไขข้อมูล{ของอัปโหลดภาพ}
        Route::get('/service/delete/{id}',[ServiceController::class,'delete']);//Route ของการลบ{ของอัปโหลดภาพ}

});

//---------------------------------------------------------------------------------------------------------------//
