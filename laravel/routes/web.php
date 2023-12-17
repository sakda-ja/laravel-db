<?php

use App\Models\User; //ประกาศดึง Model เข้ามาทำงาน
use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
});


//Route ของ Dashboard
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function ()
{
    Route::get('/dashboard', function ()
    {
        $users = User::all(); //นำมากจาก Model User; ที่ประกาศ = User ตัวนี้มาจากชื่อตารางในฐานข้อมูล
        return view('dashboard' , compact('users'));
    })->name('dashboard');
});



