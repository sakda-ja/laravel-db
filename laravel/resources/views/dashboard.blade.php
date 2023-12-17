<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- {{ __('Dashboard') }} --}}
            ระบบบันทึกข้อมูล | สวัสดีคุณ : {{Auth::user()->name}}
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
                            <th scope="col">วันที่</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php($i=1) {{--ฟังชั่นนับจำนวนเพิ่มทีละ1 --}}
                    @foreach ($users as $row)
                                <tr>
                                    <th scope="row">{{$i++}}</th> {{--ฟังชั่นนับจำนวนเพิ่มทีละ1 ++ --}}
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>{{$row->created_at}}</td>
                                </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
</x-app-layout>
