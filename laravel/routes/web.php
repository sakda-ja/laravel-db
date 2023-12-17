<?php

// use App\Models\User; //ประกาศดึง Model เข้ามาทำงาน

use App\Http\Controllers\DepartmentController; //import สร้าง Route ของ Folder department
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route ของ หน้าแรก
Route::get('/', function () {
    return view('welcome');
});


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


//Route ของ Folder admin/department
Route::get('/department/all' , [DepartmentController::class , 'index'] )->name('department');
//Route ของการเพิ่มข้อมูล
Route::post('/department/add' , [DepartmentController::class , 'store'] )->name('addDepartment');
