@extends('sidebar')
@section('content')

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Bình luận</span>
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
                <th>Người bình luận</th>
                <th>Nội dung bình luận</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($binhluan as $key => $value)
                <tr>
                    <td>{{$value->tentruyen}}</td>
                    <td>
                        <img height="100" width="110" src="{{asset('uploads/truyen/'.$value->hinhnen)}}" alt="{{$value->tentruyen}}">
                    </td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->noidungbinhluan}}</td>
                    <td>
                        <button id="{{$value->mabinhluan}}" class='btn btn-success hienbinhluan'>Hiện</button>
                    </td>
                </tr>
            @endforeach
            @foreach ($traloi as $key => $value2)
                <tr>
                    <td>{{$value2->tentruyen}}</td>
                    <td>
                        <img height="100" width="110" src="{{asset('uploads/truyen/'.$value2->hinhnen)}}" alt="{{$value2->tentruyen}}">
                    </td>
                    <td>{{$value2->email}}</td>
                    <td>{{$value2->noidungtraloi}}</td>
                    <td>
                        <button id="{{$value2->matraloi}}" class='btn btn-success hientraloi'>Hiện</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Tên truyện</th>
                <th>Hình nền</th>
                <th>Người bình luận</th>
                <th>Nội dung bình luận</th>
                <th>#</th>
            </tr>
        </tfoot>
    </table>

</div>

<script>
    $(document).ready(function() {
        $('.hienbinhluan').click(function(){
            var mabinhluan = $(this).attr('id');
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:"{{url('/hienbinhluan')}}",
                method:"POST",
                data:{mabinhluan:mabinhluan, _token:_token},
                success:function(){
                    location.reload();
                }
            });
        });
        $('.hientraloi').click(function(){
            var matraloi = $(this).attr('id');
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:"{{url('/hientraloi')}}",
                method:"POST",
                data:{matraloi:matraloi, _token:_token},
                success:function(){
                    location.reload();
                }
            });
        });
    });
</script>

@endsection
