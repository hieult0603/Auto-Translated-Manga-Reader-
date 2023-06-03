@extends('sidebar')
@section('content')

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Cập nhật tình trạng</span>
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
                <th>Tác giả</th>
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $key => $value)
                <tr>
                    <td>{{$value->tentruyen}}</td>
                    <td>
                        <img height="100" width="110" src="{{asset('uploads/truyen/'.$value->hinhnen)}}" alt="{{$value->tentruyen}}">
                    </td>
                    <td>{{$value->tacgia}}</td>
                    <td>
                        @if ($value->tinhtrang == 0)
                            <button id="{{$value->matruyen}}" class='btn btn-primary truyenhoanthanh'>Đang tiến hành</button>
                        @else
                            <button id="{{$value->matruyen}}" class='btn btn-success truyendangtienhanh'>Đã hoàn thành</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Tên truyện</th>
                <th>Hình nền</th>
                <th>Tác giả</th>
                <th>Tình trạng</th>
            </tr>
        </tfoot>
    </table>

</div>

<script>
    $(document).ready(function() {
        $('.truyenhoanthanh').click(function(){
            var matruyen = $(this).attr('id');
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:"{{url('/themtruyenhoanthanh')}}",
                method:"POST",
                data:{matruyen:matruyen, _token:_token},
                success:function(){
                    location.reload();
                }
            });
        });
        $('.truyendangtienhanh').click(function(){
            var matruyen = $(this).attr('id');
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:"{{url('/botruyenhoanthanh')}}",
                method:"POST",
                data:{matruyen:matruyen, _token:_token},
                success:function(){
                    location.reload();
                }
            });
        });
    });
</script>

@endsection
