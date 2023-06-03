<!DOCTYPE html>
<html lang="vi">
   <head>
      <meta charset="utf-8" />
      <meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
      <meta name="theme-color" content="#234556">
      <meta http-equiv="Content-Language" content="vi" />
      <meta content="VN" name="geo.region" />
      <meta name="DC.language" scheme="utf-8" content="vi" />
      <meta name="language" content="Việt Nam">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
      <link rel="shortcut icon" href="https://res.cloudinary.com/v-network/image/upload/v1663523751/favicon_h5xid7.ico">
      <meta name="revisit-after" content="1 days" />
      <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
      <title>{{$titletruyen->tentruyen}} chap {{$titletruyen->sochap}}</title>

      <meta name="description" content="Truyện hay - Xem Truyện {{$titletruyen->tentruyen}} chapter {{$titletruyen->sochap}} hay nhất, xem Truyện {{$titletruyen->tentruyen}} online miễn phí" />
      <link rel="canonical" href="{{Request::url()}}">
      <link rel="next" href="" />
      <meta property="og:locale" content="vi_VN" />
      <meta property="og:title" content="Truyện {{$titletruyen->tentruyen}} chapter {{$titletruyen->sochap}}" />
      <meta property="og:site_name" content="TruyenMoi">
      <meta property="og:description" content="Truyện Mới - Xem Truyện {{$titletruyen->tentruyen}} chapter {{$titletruyen->sochap}}" />
      <meta property="og:url" content="{{Request::url()}}" />
      @foreach ($chap as $key => $chaps)
      <meta property="og:image" content="{{asset('uploads/truyen/'.$chaps->hinhnen)}}" />
      @endforeach
      <meta property="og:image:width" content="250" />
      <meta property="og:image:height" content="320" />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
      <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     
      <link rel='dns-prefetch' href='//s.w.org' />
      
      <link rel='stylesheet' id='bootstrap-css' href='{{asset('resources/css/bootstrap.min.css?ver=5.7.2')}}' media='all' />
      <link rel='stylesheet' id='style-css' href='{{asset('resources/css/style.css?ver=5.7.2')}}' media='all' />
      <link rel='stylesheet' id='wp-block-library-css' href='{{asset('resources/css/style.min.css?ver=5.7.2')}}' media='all' />
      <script type='text/javascript' src='{{asset('resources/js/jquery.min.js?ver=5.7.2')}}' id='halim-jquery-js'></script>
      <style type="text/css" id="wp-custom-css">
         .textwidget p a img {
         width: 100%;
         }
      </style>
      <style>#header .site-title {background: url(https://res.cloudinary.com/v-network/image/upload/v1656476023/logo-truyenmoi_q4nkw1.png) no-repeat top left;background-size: contain;text-indent: -9999px; height: 30px; margin-top: 10px;}</style>
      <link rel="stylesheet" href="{{asset('resources/css/add.css')}}">
   </head>
   <body class="home blog halimthemes halimmovies" data-masonry="" onload="checkSizeWidth()" onscroll="myFunction()" onresize="checkSizeWidth()">
      <header id="header">
         <div class="container">
            <div class="row" id="headwrap">
               <div class="col-md-3 col-sm-6 slogan">
                  <p class="site-title"><a class="logo" href="{{url('/')}}" title="Truyện mới">Truyện Mới</a></p>
               </div>
               <div class="col-md-5 col-sm-6 halim-search-form hidden-xs">
                  <div class="header-nav">
                     <style type="text/css">
                        ul#result{
                           position: absolute;
                           z-index: 9999;
                           background: #1b2d3c;
                           width: 100%;
                           padding: 10px;
                           margin-top: 6px;
                           margin-left: -15px;
                           max-height: 450px;
                           overflow-y: auto;
                        }
                     </style>
                     <div class="col-xs-12">
                        <form id="search-form-pc" name="halimForm" role="search" action="{{url('/tim-kiem')}}" method="GET">
                           <div class="form-group">
                              <div class="input-group col-xs-12" style="display: flex;">
                                 <input id="timkiem" type="text" name="search" class="form-control" placeholder="Nhập tên truyện..." autocomplete="off" required>
                                 <button class="btn btn-primary" style="color: #fff;">Tìm</button>
                                 <i class="animate-spin hl-spin4 hidden"></i>
                              </div>
                              <ul class="list-group" id="result" style="display: none;">
                              
                              </ul>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               @auth
               <div class="dropdown show-up-767 hide" onclick="checkAllNotify()">
                  <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class='bx bx-bell' style="font-size:24px; padding: 5px; color: #fff; position:fixed; right: 0" title="Thông báo">
                        @if ($checkNotify && $count_notification > 0)
                           <span class="count-notification">{{$count_notification}}</span>
                        @endif
                     </i>
                  </div>
                  <div class="dropdown-menu notification" aria-labelledby="dropdownMenuButton">
                     <div class="center text-dark fontsize-20">Thông báo</div>
                     @if ($checkNotify)
                        @foreach ($thongbaobinhluan as $key => $thongbaobinhluans)
                           <div style="border-bottom: 1px solid #ccc;">
                              <a href="{{url('/truyen-tranh/'.$thongbaobinhluans->duongdantruyen.'#gotocomments')}}" style="width: 100%; color: #000;">
                                 <div style="display: flex; flex-direction: colunm">
                                    <div style="display: flex;">
                                       @if ($thongbaobinhluans->image)
                                          <img style="height: 60px; width: 60px; margin-right: 10px; margin-top: 10px" src="{{asset('/uploads/hoso/'.$thongbaobinhluans->image)}}" alt="{{$thongbaobinhluans->name}}">
                                       @else
                                          <img style="height: 60px; width: 60px; margin-right: 10px; margin-top: 10px" src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="{{$thongbaobinhluans->name}}">
                                       @endif
                                       <div>
                                          <span class="font-weight-bold">{{$thongbaobinhluans->name}}</span> đã trả lời bình luận của bạn trong truyện <span class="font-weight-bold">{{$thongbaobinhluans->tentruyen}}</span>
                                          <h5 class="noidungtraloi">{{$thongbaobinhluans->noidungtraloi}}</h5>
                                          <h5>{{\Carbon\Carbon::parse($thongbaobinhluans->ngaytraloi)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}</h5>
                                       </div>
                                    </div>
                                    <div></div>
                                 </div>
                              </a>
                           </div>
                        @endforeach
                     @endif
                  </div>
               </div>
               @endauth
            </div>
         </div>
      </header>
      <div class="navbar-container">
         <div class="container">
            <nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="1">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#halim" aria-expanded="false">
                  <span class="sr-only">Menu</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a id="check-hide-logo" class="hide-header" href="{{url('/')}}"><img class="img-logo" src="https://res.cloudinary.com/v-network/image/upload/v1656476023/logo-truyenmoi_q4nkw1.png" title="trang chủ"></a>
                  @auth
                  <div class="dropdown show-down-767 hide" onclick="checkAllNotify()">
                     <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell' style="font-size:24px; padding: 5px; color: #fff;" title="Thông báo">
                           @if ($checkNotify && $count_notification > 0)
                              <span class="count-notification">{{$count_notification}}</span>
                           @endif
                        </i>
                     </div>
                     <div class="dropdown-menu notification" aria-labelledby="dropdownMenuButton">
                        <div class="center text-dark fontsize-20">Thông báo</div>
                     @if ($checkNotify)
                        @foreach ($thongbaobinhluan as $key => $thongbaobinhluans)
                           <div style="border-bottom: 1px solid #ccc;">
                              <a href="{{url('/truyen-tranh/'.$thongbaobinhluans->duongdantruyen.'#gotocomments')}}" style="width: 100%; color: #000;">
                                 <div style="display: flex; flex-direction: colunm">
                                    <div style="display: flex;">
                                       @if ($thongbaobinhluans->image)
                                          <img style="height: 60px; width: 60px; margin-right: 10px; margin-top: 10px" src="{{asset('/uploads/hoso/'.$thongbaobinhluans->image)}}" alt="{{$thongbaobinhluans->name}}">
                                       @else
                                          <img style="height: 60px; width: 60px; margin-right: 10px; margin-top: 10px" src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="{{$thongbaobinhluans->name}}">
                                       @endif
                                       <div>
                                          <span class="font-weight-bold">{{$thongbaobinhluans->name}}</span> đã trả lời bình luận của bạn trong truyện <span class="font-weight-bold">{{$thongbaobinhluans->tentruyen}}</span>
                                          <h5 class="noidungtraloi">{{$thongbaobinhluans->noidungtraloi}}</h5>
                                          <h5>{{\Carbon\Carbon::parse($thongbaobinhluans->ngaytraloi)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}</h5>
                                       </div>
                                    </div>
                                    <div></div>
                                 </div>
                              </a>
                           </div>
                        @endforeach
                     @endif
                     </div>
                  </div>
                  @endauth
                  <button type="button" class="navbar-toggle collapsed pull-right expand-search-form" data-toggle="collapse" data-target="#search-form" aria-expanded="false">
                     <i style="font-size: 17px; color: #fff;" class='bx bx-search'></i>
                  </button>
               </div>
               <div class="collapse navbar-collapse" id="halim">
                  <div class="menu-menu_1-container">
                     <ul id="menu-menu_1" class="nav navbar-nav navbar-left">
                        <li class="current-menu-item active"><a title="Trang Chủ" href="{{url('/')}}">TRANG CHỦ</a></li>
                        <li class="mega"><a title="Truyện Hot" href="{{ url('/truyen-hot') }}">TRUYỆN HOT</a></li>
                        <li class="mega dropdown">
                            <a title="Thể Loại" href="#" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">THỂ LOẠI <span class="caret"></span></a>
                            <ul role="menu" class=" dropdown-menu">
                              @foreach($theloai as $theloais)
                                <li><a title="{{$theloais->tentheloai}}" href="{{ url('/the-loai/'.$theloais->duongdantheloai) }}">{{$theloais->tentheloai}}</a></li>
                              @endforeach
                            </ul>
                        </li>
                        @guest
                           <li class="mega"><a title="Theo Dõi" href="{{ url('/theo-doi/')}}">THEO DÕI</a></li>
                           <li class="mega"><a title="Lịch Sử" href="{{ url('/lich-su/')}}">LỊCH SỬ</a></li>
                        @else
                           <li class="mega"><a title="Theo Dõi" href="{{ url('/theo-doi/'.Auth::user()->id)}}">THEO DÕI</a></li>
                           <li class="mega"><a title="Lịch Sử" href="{{ url('/lich-su/'.Auth::user()->id)}}">LỊCH SỬ</a></li>
                        @endguest
                        @guest
                           <li class="mega dropdown">
                              <a title="Cá Nhân" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">CÁ NHÂN <span class="caret"></span></a>
                              <ul  role="menu" class=" dropdown-menu" id="dropdown-login">
                                 <!-- Authentication Links -->
                                 @if (Route::has('login'))
                                    <li class="nav-item">
                                       <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                 @endif

                                 @if (Route::has('register'))
                                    <li class="nav-item">
                                       <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                 @endif
                              </ul>
                           </li>
                        @else
                           <li class="mega dropdown">
                              <a title="Cá Nhân" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true">{{ Auth::user()->name }} <span class="caret"></span></a>
                              <ul  role="menu" class=" dropdown-menu" id="dropdown-login">
                                 <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{url('hoso/'.Auth::user()->id)}}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                       Hồ Sơ 
                                    </a>
                                 </li>
                                 <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                          {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                          @csrf
                                    </form>
                                 </li>
                              </ul>
                           </li>
                        @endguest
                     </ul>
                  </div>
               </div>
            </nav>
            <div class="collapse navbar-collapse" id="search-form">
               <div id="mobile-search-form" class="halim-search-form"></div>
            </div>
            <div class="collapse navbar-collapse" id="user-info">
               <div id="mobile-user-login"></div>
            </div>
         </div>
      </div>
      </div>
      
      <div class="container">
         <div class="row fullwith-slider"></div>
      </div>
      <div class="container">
            <div class="row container" id="wrapper">
                <div class="halim-panel-filter">
                <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                    <div class="ajax"></div>
                </div>
                </div>
                @yield('content')
            </div>
      </div>
      <div class="clearfix"></div>
      <footer id="footer" class="clearfix">
         <div class="container footer-columns">
            <div class="row container">
               <div class="widget about col-xs-4 col-sm-4 col-md-4 full-width-col">
                  <div class="footer-logo">
                     <a href="{{url('/')}}">
                        <img class="img-responsive" src="https://res.cloudinary.com/v-network/image/upload/v1656476023/logo-truyenmoi_q4nkw1.png" alt="Truyện hay 2022- Xem Truyện hay nhất" />
                     </a>
                  </div>
                  Copyright © 2023 LeThanhHieu
               </div>
               <div class="col-xs-8 col-sm-8 col-md-8 full-width-col">
                  <div style="width: 100%; font-size: 18px; color: #fff;">Từ khóa</div>
                  <div style="width: 100%; display: flex; flex-wrap: wrap;">
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">Truyện tranh</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">Truyen tranh online</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">Truyện tranh hot</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">Truyện qq</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">doctruyen3q</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">cmanga</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">vlogtruyen</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">blogtruyen</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">saytruyen</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">truyentranhaudio</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">hamtruyen</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">truyensieuhay</div></a>
                     <a style="color: #fff; text-decoration: none;" href="{{url('/')}}"><div class="tagsBtn">vcomi</div></a>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <div id='easy-top'></div>
     
      <script type='text/javascript' src='{{asset('resources/js/bootstrap.min.js?ver=5.7.2')}}' id='bootstrap-js'></script>
      <script type='text/javascript' src='{{asset('resources/js/owl.carousel.min.js?ver=5.7.2')}}' id='carousel-js'></script>
     
      <script type='text/javascript' src='{{asset('resources/js/halimtheme-core.min.js?ver=1626273138')}}' id='halim-init-js'></script>
      
   
      <style>#overlay_mb{position:fixed;display:none;width:100%;height:100%;top:0;left:0;right:0;bottom:0;background-color:rgba(0, 0, 0, 0.7);z-index:99999;cursor:pointer}#overlay_mb .overlay_mb_content{position:relative;height:100%}.overlay_mb_block{display:inline-block;position:relative}#overlay_mb .overlay_mb_content .overlay_mb_wrapper{width:600px;height:auto;position:relative;left:50%;top:50%;transform:translate(-50%, -50%);text-align:center}#overlay_mb .overlay_mb_content .cls_ov{color:#fff;text-align:center;cursor:pointer;position:absolute;top:5px;right:5px;z-index:999999;font-size:14px;padding:4px 10px;border:1px solid #aeaeae;background-color:rgba(0, 0, 0, 0.7)}#overlay_mb img{position:relative;z-index:999}@media only screen and (max-width: 768px){#overlay_mb .overlay_mb_content .overlay_mb_wrapper{width:400px;top:3%;transform:translate(-50%, 3%)}}@media only screen and (max-width: 400px){#overlay_mb .overlay_mb_content .overlay_mb_wrapper{width:310px;top:3%;transform:translate(-50%, 3%)}}</style>
    
      <style>
         #overlay_pc {
         position: fixed;
         display: none;
         width: 100%;
         height: 100%;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: rgba(0, 0, 0, 0.7);
         z-index: 99999;
         cursor: pointer;
         }
         #overlay_pc .overlay_pc_content {
         position: relative;
         height: 100%;
         }
         .overlay_pc_block {
         display: inline-block;
         position: relative;
         }
         #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
         width: 600px;
         height: auto;
         position: relative;
         left: 50%;
         top: 50%;
         transform: translate(-50%, -50%);
         text-align: center;
         }
         #overlay_pc .overlay_pc_content .cls_ov {
         color: #fff;
         text-align: center;
         cursor: pointer;
         position: absolute;
         top: 5px;
         right: 5px;
         z-index: 999999;
         font-size: 14px;
         padding: 4px 10px;
         border: 1px solid #aeaeae;
         background-color: rgba(0, 0, 0, 0.7);
         }
         #overlay_pc img {
         position: relative;
         z-index: 999;
         }
         @media only screen and (max-width: 768px) {
         #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
         width: 400px;
         top: 3%;
         transform: translate(-50%, 3%);
         }
         .botheodoi {
                max-width: 40px;
            }
         .textbotheodoi{
               display: none;
         }
         .tentruyen{
            font-size: 14px;
            max-height: 32px;
         }
         .sochaptruyen{
            font-size: 12px;
         }
         .ngaycapnhatchap{
            font-size: 10px;
         }
         .xemchapmoi{
            width: 40%;
            text-align: left;
         }
         .xemngaychapmoi{
            width: 60%;
            text-align: right;
         }
         }
         @media only screen and (max-width: 400px) {
         #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
         width: 310px;
         top: 3%;
         transform: translate(-50%, 3%);
         }
         .tentruyen{
            font-size: 12px;
            max-height: 32px;
         }
         .sochaptruyen{
            font-size: 11px;
         }
         .ngaycapnhatchap{
            font-size: 10px;
         }
         .xemchapmoi{
            width: 40%;
            text-align: left;
         }
         .xemngaychapmoi{
            width: 60%;
            text-align: right;
         }
         }
         @media only screen and (max-width: 300px) {
         .tentruyen{
            font-size: 12px;
            max-height: 32px;
         }
         .sochaptruyen{
            font-size: 9px;
         }
         .ngaycapnhatchap{
            font-size: 9px;
         }
         .xemchapmoi{
            width: 40%;
            text-align: left;
         }
         .xemngaychapmoi{
            width: 60%;
            text-align: right;
         }
         }
      </style>
     
      <style>
         .float-ck { position: fixed; bottom: 0px; z-index: 9}
         * html .float-ck /* IE6 position fixed Bottom */{position:absolute;bottom:auto;top:expression(eval (document.documentElement.scrollTop+document.docum entElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0))) ;}
         #hide_float_left a {background: #0098D2;padding: 5px 15px 5px 15px;color: #FFF;font-weight: 700;float: left;}
         #hide_float_left_m a {background: #0098D2;padding: 5px 15px 5px 15px;color: #FFF;font-weight: 700;}
         span.bannermobi2 img {height: 70px;width: 300px;}
         #hide_float_right a { background: #01AEF0; padding: 5px 5px 1px 5px; color: #FFF;float: left;}
         .tentruyen{
            font-size: 14px;
            max-height: 32px;
         }
         .sochaptruyen{
            font-size: 12px;
         }
         .ngaycapnhatchap{
            font-size: 11px;
         }
         .xemchapmoi{
            width: 45%;
            text-align: left;
         }
         .xemngaychapmoi{
            width: 55%;
            text-align: right;
         }
      </style>

      <script>
         function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
         }
      </script>

      <script src="{{asset('resources/js/autosize.min.js')}}"></script>
      <script>autosize(document.querySelectorAll('#autosize'));</script>

      <script>
         function showreply(id) {
            document.getElementById('showreply'+id).style.cssText = 'display: block;';
         }
      </script>

      <script>
         function showreplys(id) {
            document.getElementById('showreplys'+id).style.cssText = 'display: block;';
         }
      </script>

      <script>
         // function changeCss () {
         //    var bodyElement = document.querySelector("body");
         //    var navElement = document.querySelector("nav");
         //    this.scrollY > 200 ? document.getElementById('showstickys').style.cssText = 'position:fixed; top: 0; background: #3b6080; z-index: 999; width: 100%;' : document.getElementById('showstickys').style.cssText = '';
         // }
         // window.addEventListener("scroll", changeCss , false);
         var previousScroll = 0;
         $(window).scroll(function () {
            if (this.scrollY > 200) {
               var currentScroll = $(this).scrollTop();
               if (currentScroll > previousScroll) {
                  document.getElementById('showstickys').style.cssText = ''
               } else {
                  document.getElementById('showstickys').style.cssText = 'position:fixed; top: 50px; background: #ccc; z-index: 999; width: 100%;'
               }
               previousScroll = currentScroll;
            } else {
                  document.getElementById('showstickys').style.cssText = ''
            }
         });
      </script>

      <script>
         $('.luachontaptruyen').change(function(){
            var url = $(this).find(':selected').val();
            // alert(url);
            window.location.href = url;
         })
      </script>

      <script type="text/javascript">
         $(document).ready(function(){

            $('#timkiem').keyup(function(){
               $('#result').html('');
               var search = $('#timkiem').val();
               if(search!=''){
                  var expression = new RegExp(search, "i");
                  $.getJSON('http://localhost/truyenmoi/public/json/truyen.json', function(data){
                     $.each(data, function(key, value){
                        if(value.tentruyen.search(expression)!=-1 || value.tentienganh.search(expression)!=-1 || value.noidungtruyen.search(expression)!=-1){
                           $('#result').css('display','inherit');
                           $('#result').append('<a href="/truyenmoi/truyen-tranh/'+value.duongdantruyen+'"><div style="cursor:pointer; display: flex; height: 60px; margin-bottom: 10px; align-items: center;"><img style="width: 60px; height: 60px;" src="http://localhost/truyenmoi/uploads/truyen/'+value.hinhnen+'"/><div style="display: flex; flex-direction: column; margin-left: 10px; height: 60px; justify-content: space-between;"><div style="width: 100%; font-size:14px; text-overflow: ellipsis; -webkit-box-orient: vertical; -webkit-line-clamp: 2; display: -webkit-box; overflow: hidden;">'+value.tentruyen+'</div><div style="width: 100%; font-size:12px; white-space: nowrap;">'+value.tentienganh+'</div></div></div></a>');
                        }
                     });
                  });
               }else{
                  $('#result').css('display','none');
               }
               
            });
         })
      </script>
      
      <script>
         function myFunction(){
            if (this.scrollY > 200) {
               $('#result').css('display','none');
            }
         }
      </script>

      <script>
         function checkSizeWidth() {
            if (document.body.offsetWidth < 767) {
               $('#header').addClass('hide-header');
               $('.navbar-header').addClass('space-item-header');
               $('#check-hide-logo').removeClass('hide-header');
               $('.show-up-767').addClass('hide');
               $('.show-down-767').removeClass('hide');
            }
            if (document.body.offsetWidth > 767) {
               $('#header').removeClass('hide-header');
               $('.navbar-header').removeClass('space-item-header');
               $('#check-hide-logo').addClass('hide-header');
               $('.show-up-767').removeClass('hide');
               $('.show-down-767').addClass('hide');
            }
         }
      </script>
      @auth
      <script>
         function checkAllNotify() {
            var id = {!! auth()->user()->id !!};
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
               url:"{{url('/checkallnotification')}}",
               method:"POST",
               data:{id:id, _token:_token},
               success:function(){
               }
            });
         }
      </script>
      @endauth
      <script>
         function anbinhluan(id) {
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
               url:"{{url('/anbinhluan')}}",
               method:"POST",
               data:{id:id, _token:_token},
               success:function(){
                  location.reload();
               }
            });
         }
      </script>
      <script>
         function antraloi(id) {
            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
               url:"{{url('/antraloi')}}",
               method:"POST",
               data:{id:id, _token:_token},
               success:function(){
                  location.reload();
               }
            });
         }
      </script>

   </body>
</html>