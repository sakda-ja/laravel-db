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
                        <div class="card-header">ตารางข้อมูลรูปภาพ</div>
                        {{-- {{$departments}} --}}

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">ภาพประกอบ</th>
                                    <th scope="col">ชื่อบริการ</th>
                                    <th scope="col">ระยะเวลาที่สร้าง</th>
                                    <th scope="col">แก้ไข</th>
                                    <th scope="col">ลบ</th>
                                    {{-- <th scope="col">เริ่มใช้งานระบบ</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{--@php($i=1)--}} {{--ฟังชั่นนับจำนวนเพิ่มทีละ1 --}}
                                @foreach ($services as $row) {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                                <tr>
                                    <th scope="row">{{ $services->firstItem()+$loop->index }}</th> {{--ฟังชั่นนับจำนวนเรียงตามลำดับ 1 2 3..... --}}
                                    <td>
                                        <img src="{{asset ($row->service_image) }}" alt="" width="70px" height="70px">
                                    </td>
                                    <td>{{$row->service_name}}</td> {{-- ใช้เรียก Join Table ตาราง 'id' กับ 'user_id' --}}
                                    <td>
                                       @if ($row->created_at == null)
                                            -
                                        @else
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans() }}
                                        @endif

                                    </td>
                                    <td> <a href=" {{url ('/#/edit/'.$row->id) }}" class="btn btn-warning"> แก้ไข </a></td>
                                    <td> <a href=" {{url ('/#/softdelete/'.$row->id) }}" class="btn btn-danger"> ลบ </a></td>
                                </tr>
                                @endforeach {{--วนลูปดึงข้อมูลในฐานข้อมูลมาแสดง ++ --}}
                            </tbody>
                        </table>
                            {{$services->links() }} {{--pagination 1 2 3...>>>--}}
                    </div>
{{------------------------------------ ตาราง ------------------------------------}}

                </div> {{-- col-md-8--}}


{{------------------------------------ ฟอร์ม ------------------------------------}}
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">แบบฟอร์มรูปภาพ</div>
                        <div class="card-body">
                            <form action="{{route ('addService') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="service_name">ชื่อรูปภาพ</label>
                                    <input type="text" class="form-control" name="service_name">
                                </div>
                                @error('service_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror

{{------------------------------------ ฟอร์ม อัปโหลด------------------------------------}}

                                <div class="form-group">
                                    <label for="service_image">ภาพประกอบ</label>
                                    <input type="file" class="form-control" name="service_image">
                                </div>
                                @error('service_image')
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
