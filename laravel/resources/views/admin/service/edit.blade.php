<x-app-layout>
<!-- ---------------------------------------Nav------------------------------------------------------>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{-- {{ __('Dashboard') }} --}}
            ระบบบันทึกข้อมูล | สวัสดีคุณ : {{Auth::user()->name}}
        </h2>
    </x-slot>
<!-- ---------------------------------------Nav------------------------------------------------------>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">

                        <!-- ---------------------------------------ฟอร์ม input อัปโหลดแก้ไข------------------------------------------------------>
                        <div class="card">
                            <div class="card-header">แบบฟอร์มแก้ไขข้อมูลอัปโหลดภาพ</div>
                            <div class="card-body">

{{--
                                <form action="{{url('/service/update/'.$service->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="service_name">ชื่อบริการ</label>
                                        <input type="text" class="form-control" name="service_name" value="{{$service->service_name}}">
                                    </div>
                                    @error('service_name')
                                        <div class="my-2">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label for="service_image">ภาพประกอบ</label>
                                        <input type="file" class="form-control" name="service_image" value="{{$service->service_image}}">
                                    </div>
                                    @error('service_image')
                                        <div class="my-2">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror


                                    <br>
                                    <input type="hidden" name="old_image" value="{{$service->service_image}}">
                                    <div class="form-group">
                                        <img src="{{asset ($service->service_image)}}" alt="" width="100px" height="100px">

                                    </div>

                                    <br>
                                    <input type="submit" value="อัพเดต" class="btn btn-primary">
                                </form> --}}

                                <form action="{{url('/service/update/'.$service->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="service_name">ชื่อบริการ</label>
                                        <input type="text" class="form-control" name="service_name" value="{{$service->service_name}}">
                                    </div>
                                    @error('service_name')
                                        <div class="my-2">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror

                                    <div class="form-group">
                                        <label for="service_image">ภาพประกอบ</label>
                                        <input type="file" class="form-control" name="service_image" value="{{$service->service_image}}">
                                    </div>
                                    @error('service_image')
                                        <div class="my-2">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                    <br>
                                    <input type="hidden" name="old_image" value="{{$service->service_image}}"> {{-- ส่งไป function update--}}
                                    <div class="form-group">
                                        <img src="{{asset($service->service_image)}}" alt=" " width="400px" height="400px">
                                    </div>

                                    <br>
                                    <input type="submit" value="อัพเดต" class="btn btn-primary">
                                </form>



                            </div>
                        </div>
                        {{---------------------------------------------------------------------------------------------}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
