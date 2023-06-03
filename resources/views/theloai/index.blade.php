@extends('sidebar')
@section('content')

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Thể loại</span>
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

    <form action="{{url('/themtheloai')}}" method="post">
        @csrf
        <div class="d-flex">
            <div class="w-50 m-2">
                <label class="form-label">Tên thể loại</label>
                <input name="ten" type="text" class="form-control" onkeyup="ChangeToSlug()" id="slug">
            </div>
            <div class="w-50 m-2">
                <label class="form-label">Đường dẫn thể loại</label>
                <input name="duongdan" type="text" class="form-control" id="convert_slug">
            </div>
            <button type="submit" class="btn btn-primary m-2">Thêm thể loại</button>
        </div>
    </form>

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Mã thể loai</th>
                <th>Thể loại</th>
                <th>Đường dẫn</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $key => $value)
            <tr>
                <td>{{$value->matheloai}}</td>
                <td>{{$value->tentheloai}}</td>
                <td>{{$value->duongdantheloai}}</td>
                <td style="display: flex;">
                    <a href="{{url('/suatheloai/'.$value->matheloai)}}" style="padding-right: 10px"><i class='bx bxs-pencil'></i></a> | 
                    <a href="{{url('/xoatheloai/'.$value->matheloai)}}" style="padding-left: 10px"><i class='bx bx-trash'></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Mã thể loai</th>
                <th>Thể loại</th>
                <th>Đường dẫn</th>
                <th>#</th>
            </tr>
        </tfoot>
    </table>

</div>

@endsection
