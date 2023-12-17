<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{-- {{ __('Dashboard') }} --}}
            ระบบบันทึกข้อมูล | สวัสดีคุณ : {{Auth::user()->name}}
           <b class="float-end">
                จำนวนผู้ใช้งาน
                <span>{{count ($users)}}</span> {{--ฟังชั่นนับจำนวนผู้ใช้งานในระบบ--}}
                คน
            </b>
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Table -->
        <div class="container">
            <div class="row">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">อีเมลล์</th>
                            <th scope="col">เริ่มใช้งานระบบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($i=1) {{--ฟังชั่นนับจำนวนเพิ่มทีละ1 --}}
                        @foreach ($users as $row) {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                        <tr>
                            <th scope="row">{{$i++}}</th> {{--ฟังชั่นนับจำนวนเพิ่มทีละ1 ++ --}}
                            <td>{{$row->name}}</td>
                            <td>{{$row->email}}</td>
                            {{-- <td>{{$row->created_at ->diffForHumans() }}</td> ฟังชั่น diffForHumans() แสดงเวลาที่สมัครสร้างบัญชีในระบบ --}}
                            <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</td> {{--(กรณีมีตารางอยู่แล้ว) ใช้ฟังชั่น Carbon แปลงไปเรียก diffForHumans แสดงเวลาที่สมัครสร้างบัญชีในระบบ--}}
                        </tr>
                        @endforeach {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Table -->
    </div>
</x-app-layout>
