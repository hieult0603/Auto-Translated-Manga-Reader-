@extends('sidebar')
@section('content')

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Cập nhật tập truyện</span>
        @if (session('error'))
            <div class="alert alert-danger m-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success m-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="profile-right">
            <div class="profile-content">
                @if (Auth::user()->image)
                <img style="height: 50px; width: 50px; border-radius: 10px; padding: 5px;" src="{{asset('/uploads/hoso/'.Auth::user()->image)}}" alt="profileImg">
                @else
                <img style="height: 50px; width: 50px; border-radius: 10px; padding: 5px;" src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="image">
                @endif
            </div>
            <div class="name-job">
                <div class="profile_name dropdown" style="color: #000000; margin: 10px; font-weight: 500;">
                    <a class="btn" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <a href="{{url('hoso/'.Auth::user()->id)}}" class="dropdown-item">Hồ sơ</a>
                            <a href="{{url('theo-doi/'.Auth::user()->id)}}" class="dropdown-item">Theo dõi</a>
                            <a href="{{url('lich-su/'.Auth::user()->id)}}" class="dropdown-item">Lịch sử đọc truyện</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>   
        </div>
    </div>
</section>

<div class="showMain" style="padding: 5px;">

    @foreach ($data as $key => $value2)
    <form action="{{url('/capnhatchap/'.$value2->machap)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="d-flex">
            <div class="m-2 w-25">
                <label class="form-label">Số tập truyện</label>
                <input name="sochap" type="text" value="{{$value2->sochap}}" class="form-control">
            </div>
            <div class="m-2 w-75">
                <label class="form-label">Truyện</label>
                <select name="truyen" class="form-select" aria-label="Default select example">
                    @foreach($truyen as $key => $value)
                    <option @if($value->matruyen == $value2->matruyen) selected @else @endif value="{{$value->matruyen}}">{{$value->tentruyen}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="m-2">
            <label class="form-label">Hình tập truyện</label>
            <input type="file" name="file[]" multiple class="form-control">
        </div>
        <div class="d-flex form-control m-2" style="overflow-x: auto; width: 99%;">
            @foreach ($anhchap as $key => $value3)
                @if ($value3->machap==$value2->machap)
                    <img class="m-2" height="370" src="{{ asset('uploads/chap/'.$value3->hinhanh)}}" alt="{{$value3->hinhanh}}">
                    <a style="margin-left: -30px;" href="{{url('xoaanhchap/'.$value3->machap.'/'.$value3->hinhanh.'/'.$value3->maanhchap)}}"><i style="font-size: 24px;" class='bx bx-x btn-danger'></i></a>
                @endif
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary m-2">Cập nhật tập truyện</button>
    </form>
    @endforeach

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Tên truyện</th>
                <th>Số tập</th>
                <th>Ngày tạo</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $key => $value)
            <tr>
                <td>{{$value->tentruyen}}</td>
                <td>{{$value->sochap}}</td>
                <td>{{$value->ngaytaochap}}</td>
                <td>
                    <a href="{{url('/suachap/'.$value->machap)}}"><i class='bx bxs-pencil' style="font-size:24px; padding: 5px"></i></a> 
                    <a href="{{url('/xoachap/'.$value->machap)}}"><i class='bx bx-trash' style="font-size:24px; padding: 5px"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Tên truyện</th>
                <th>Số tập</th>
                <th>Ngày tạo</th>
                <th>#</th>
            </tr>
        </tfoot>
    </table>

</div>

@endsection
