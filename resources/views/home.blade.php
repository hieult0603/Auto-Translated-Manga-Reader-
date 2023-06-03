@extends('sidebar')
@section('content')

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Dashboard</span>
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
    </div>
</section>

<div class="showMain" style="padding: 5px;">

    <div class="col-md-9 d-flex flex-wrap">
        <div class="allview">
            <div class="label text-primary">Tổng xem ngày</div>
            <div class="allview-result"><i class='bx bx-show'></i>{{number_format($tongxemngay)}}</div>
        </div>
        <div class="allview">
            <div class="label text-primary">Tổng xem tháng</div>
            <div class="allview-result"><i class='bx bx-show'></i>{{number_format($tongxemthang)}}</div>
        </div>
        <div class="allview">
            <div class="label text-primary">Số người dùng</div>
            <div class="allview-result"><i class='bx bx-show'></i>{{number_format($users)}}</div>
        </div>
    </div>
    <br>
    <div class="col-md-12">
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <div class="class1" id="{{$tongthang1}}"></div>
        <div class="class2" id="{{$tongthang2}}"></div>
        <div class="class3" id="{{$tongthang3}}"></div>
        <div class="class4" id="{{$tongthang4}}"></div>
        <div class="class5" id="{{$tongthang5}}"></div>
        <div class="class6" id="{{$tongthang6}}"></div>
        <div class="class7" id="{{$tongthang7}}"></div>
        <div class="class8" id="{{$tongthang8}}"></div>
        <div class="class9" id="{{$tongthang9}}"></div>
        <div class="class10" id="{{$tongthang10}}"></div>
        <div class="class11" id="{{$tongthang11}}"></div>
        <div class="class12" id="{{$tongthang12}}"></div>
        <script>
            window.onload = function () {
                var CurrentYear = new Date().getFullYear();

                const thang1 = document.querySelector('.class1').id;
                const thang2 = document.querySelector('.class2').id;
                const thang3 = document.querySelector('.class3').id;
                const thang4 = document.querySelector('.class4').id;
                const thang5 = document.querySelector('.class5').id;
                const thang6 = document.querySelector('.class6').id;
                const thang7 = document.querySelector('.class7').id;
                const thang8 = document.querySelector('.class8').id;
                const thang9 = document.querySelector('.class9').id;
                const thang10 = document.querySelector('.class10').id;
                const thang11 = document.querySelector('.class11').id;
                const thang12 = document.querySelector('.class12').id;

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    title:{
                        text: "Biểu đồ lượt xem năm "+CurrentYear
                    },
                    data: [{        
                        type: "line",
                        indexLabelFontSize: 16,
                        dataPoints: [
                            { x: 1, y: +thang1 },
                            { x: 2, y: +thang2 },
                            { x: 3, y: +thang3 },
                            { x: 4, y: +thang4 },
                            { x: 5, y: +thang5 },
                            { x: 6, y: +thang6 },
                            { x: 7, y: +thang7 },
                            { x: 8, y: +thang8 },
                            { x: 9, y: +thang9 },
                            { x: 10, y: +thang10 },
                            { x: 11, y: +thang11 },
                            { x: 12, y: +thang12 }
                        ]
                    }]
                });
                chart.render();
            }
        </script>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </div>

</div>

@endsection
