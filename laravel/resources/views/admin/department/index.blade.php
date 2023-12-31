<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{-- {{ __('Dashboard') }} --}}
            ระบบบันทึกข้อมูล | สวัสดีคุณ : {{Auth::user()->name}}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    @if(session("success"))<!--ดึง session ข้อความมาแสดง -->
                        <div class="alert alert-success"> {{ session ('success') }}</div> <!--แสดงแถบ Alert  -->
                    @endif
{{------------------------------------ ตาราง ------------------------------------}}
                    <div class="card">
                        <div class="card-header">ตารางข้อมูล</div>
                        {{-- {{$departments}} --}}

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อ</th>
                                    <th scope="col">ยูสเซอร์ไดี</th>
                                    <th scope="col">ระยะเวลาที่สร้าง</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                    {{-- <th scope="col">เริ่มใช้งานระบบ</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{--@php($i=1)--}} {{--ฟังชั่นนับจำนวนเพิ่มทีละ1 --}}
                                @foreach ($departments as $row) {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                                <tr>
                                    <th scope="row">{{ $departments->firstItem()+$loop->index }}</th> {{--ฟังชั่นนับจำนวนเรียงตามลำดับ 1 2 3..... --}}
                                    <td>{{$row->department_name}}</td>
                                    <td>{{$row->user->name}}</td> {{-- ใช้เรียก Join Table ตาราง 'id' กับ 'user_id' --}}
                                    <td>
                                       @if ($row->created_at == null)
                                            -
                                        @else
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                        @endif

                                    </td>
                                    <td> <a href=" {{url ('/department/edit/'.$row->id) }}" class="btn btn-warning"> แก้ไข </a></td>
                                    <td> <a href=" {{url ('/department/softdelete/'.$row->id) }}" class="btn btn-danger"> ลบ </a></td>
                                </tr>
                                @endforeach {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                            </tbody>
                        </table>
                            {{$departments->links() }} {{--pagination 1 2 3...>>>--}}
                    </div>
{{------------------------------------ ตาราง ------------------------------------}}


@if (count ($trashDepartments)>0)
{{------------------------------------ ถังขยะ ------------------------------------}}
                    <div class="my-3 card border-warning">
                        <div class="card-header ">ถังขยะ</div>
                        {{-- {{$departments}} --}}

                        <table class="table table-bordered table-warning">
                            <thead class="table-dark ">
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ชื่อ</th>
                                    <th scope="col">ยูสเซอร์ไดี</th>
                                    <th scope="col">ระยะเวลาที่สร้าง</th>
                                    <th scope="col">กู้คืน</th>
                                    <th scope="col">ลบถาวร</th>
                                    {{-- <th scope="col">เริ่มใช้งานระบบ</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{--@php($i=1)--}} {{--ฟังชั่นนับจำนวนเพิ่มทีละ1 --}}
                                @foreach ($trashDepartments as $row) {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                                <tr>
                                    <th scope="row">{{ $trashDepartments->firstItem()+$loop->index }}</th> {{--ฟังชั่นนับจำนวนเรียงตามลำดับ 1 2 3..... --}}
                                    <td>{{$row->department_name}}</td>
                                    <td>{{$row->user->name}}</td> {{-- ใช้เรียก Join Table ตาราง 'id' กับ 'user_id' --}}
                                    <td>
                                       @if ($row->created_at == null)
                                            -
                                        @else
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                        @endif

                                    </td>
                                    <td> <a href=" {{url ('/department/restore/'.$row->id) }}" class="btn btn-success"> กู้คืน </a></td>
                                    <td> <a href=" {{url ('/department/delete/'.$row->id) }}" class="btn btn-secondary"> ลบถาวร </a></td>
                                </tr>
                                @endforeach {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                            </tbody>
                        </table>
                        {{ $trashDepartments->links() }} {{--pagination 1 2 3...>>>--}}
                    </div>
{{------------------------------------ ถังขยะ ------------------------------------}}
@endif
                </div> {{-- col-md-8--}}


{{------------------------------------ ฟอร์ม ------------------------------------}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์ม</div>
                        <div class="card-body">
                            <form action="{{route('addDepartment')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="department_name">ชื่อแผนก</label>
                                    <input type="text" class="form-control" name="department_name">
                                </div>
                                @error('department_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <br>
                                <input type="submit" value="บันทึก" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
{{------------------------------------ ฟอร์ม ------------------------------------}}

            </div> {{-- row--}}
        </div> {{-- container--}}
    </div>


</x-app-layout>
