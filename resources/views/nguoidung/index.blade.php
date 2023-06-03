@extends('sidebar')
@section('content')

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Người dùng</span>
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
</section>

<div class="showMain" style="padding: 5px;">

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Phân quyền</th>
                <th>Khóa tài khoản</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $key => $value)
                <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    <td>
                        <select name="permission" class="form-select select-permission-user" aria-label="Default select example" id="{{$value->id}}">
                            @if($value->permission==0)
                                <option value="0" selected>người dùng</option>
                                <option value="1">người quản trị</option>
                                <option value="2">người đăng truyện</option>
                            @endif
                            @if($value->permission==1)
                                <option value="0">người dùng</option>
                                <option value="1" selected>người quản trị</option>
                                <option value="2">người đăng truyện</option>
                            @endif
                            @if($value->permission==2)
                                <option value="0">người dùng</option>
                                <option value="1">người quản trị</option>
                                <option value="2" selected>người đăng truyện</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        @if ($value->lock_account == 0)
                            <div class="btn btn-success khoataikhoang" id="{{$value->id}}">Mở</div>
                        @else
                            <div class="btn btn-danger motaikhoang" id="{{$value->id}}">Khóa</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>id</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Phân quyền</th>
                <th>Khóa tài khoản</th>
            </tr>
        </tfoot>
    </table>

</div>

<script type="text/javascript">
    $('.select-permission-user').change(function(){
        var permission = $(this).find(':selected').val();
        var id = $(this).attr('id');
        let _token   = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url:"{{url('/phanquyennguoidung')}}",
            method:"POST",
            data:{id:id, permission:permission, _token:_token},
            success:function(){}
        });
    })
</script>

<script>
    $(document).ready(function() {
        $('.khoataikhoang').click(function(){
            var id = $(this).attr('id');
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:"{{url('/khoataikhoang')}}",
                method:"POST",
                data:{id:id, _token:_token},
                success:function(){
                    location.reload();
                }
            });
        });
        $('.motaikhoang').click(function(){
            var id = $(this).attr('id');
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:"{{url('/motaikhoang')}}",
                method:"POST",
                data:{id:id, _token:_token},
                success:function(){
                    location.reload();
                }
            });
        });
    });
</script>

@endsection
