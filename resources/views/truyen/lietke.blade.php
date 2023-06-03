@extends('sidebar')
@section('content')

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Danh sách truyện</span>
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

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Tên truyện</th>
                <th>Hình nền</th>
                <th>Nội dung</th>
                <th>Thể loại</th>
                <th>Tên tiếng anh</th>
                <th>Truyện hot</th>
                <th>Hiển thị</th>
                <th>Tên tác giả</th>
                <th>Đường dẫn</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $key => $value)
            <tr>
                <td>{{$value->tentruyen}}</td>
                <td>
                    <img width="100" src="{{asset('uploads/truyen/'.$value->hinhnen)}}" alt="{{$value->tentruyen}}">
                </td>
                <td>{{$value->noidungtruyen}}</td>
                <td>
                    @foreach ($truyen_theloai as $item)
                        @if($item->matruyen == $value->matruyen)
                        <span class="btn btn-secondary btn-sm m-1">{{$item->tentheloai}}</span> 
                        @endif
                    @endforeach
                </td>
                <td>{{$value->tentienganh}}</td>
                <td>
                    @if ($value->truyenhot == 1)
                        có
                    @else
                        không
                    @endif
                </td>
                <td>
                    @if ($value->hienthi == 1)
                        có
                    @else
                        không
                    @endif
                </td>
                <td>{{$value->tacgia}}</td>
                <td>{{$value->duongdantruyen}}</td>
                <td>{{$value->ngaytao}}</td>
                <td>{{$value->ngaycapnhat}}</td>
                <td>
                    <a href="{{url('/suatruyen/'.$value->matruyen)}}"><i class='bx bxs-pencil' style="font-size:24px; padding: 5px"></i></a> 
                    <a href="{{url('/xoatruyen/'.$value->matruyen)}}"><i class='bx bx-trash' style="font-size:24px; padding: 5px"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Tên truyện</th>
                <th>Hình nền</th>
                <th>Nội dung</th>
                <th>Thể loại</th>
                <th>Tên tiếng anh</th>
                <th>Truyện hot</th>
                <th>Hiển thị</th>
                <th>Tên tác giả</th>
                <th>Đường dẫn</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>#</th>
            </tr>
        </tfoot>
    </table>

</div>

@endsection
