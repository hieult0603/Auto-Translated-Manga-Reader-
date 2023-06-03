@extends('welcome2')

@section('content')

<div class="row container" id="wrapper">
    @foreach($truyen as $key => $value)
        <div class="halim-panel-filter">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <div class="yoast_breadcrumb hidden-xs">
                        <span>
                            <span>
                                <a href="{{url('/')}}">trang chủ</a> » 
                                <span>
                                    @foreach ($truyen_theloai as $key => $value2)
                                        @if($value->matruyen == $value2->matruyen)
                                            <a href="{{url('/the-loai/'.$value2->duongdantheloai)}}">{{$value2->tentheloai}}</a> » 
                                        @endif
                                    @endforeach
                                    <span class="breadcrumb_last" aria-current="page">{{$value->tentruyen}}</span>
                                </span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
            <div class="ajax"></div>
        </div>
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
        <section id="content" class="test">
            <div class="clearfix wrap-content">
                
                <div class="halim-movie-wrapper">
                    <div class="movie_info col-xs-12">
                    <div class="movie-poster col-md-3">
                        <img class="movie-thumb" src="{{asset('uploads/truyen/'.$value->hinhnen)}}" alt="{{$value->tentruyen}}">
                        
                    </div>
                    <div class="film-poster col-md-9">
                        <h1 title="{{$value->tentruyen}}" class="title-1" style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">{{$value->tentruyen}}</h1>
                        <h2 class="title-2" style="font-size: 12px;">{{$value->tentienganh}}</h2>
                        <ul class="list-info-group">
                            <li class="list-info-group-item">
                                <span>Tác giả</span> : 
                                <span class="imdb">{{$value->tacgia}}</span>
                            </li>
                            <li class="list-info-group-item">
                                <span>Cập nhật lúc</span> : &#160; {{$value->ngaycapnhat}}
                            </li>
                            <li class="list-info-group-item">
                                <span>Tình trạng</span> : &#160; @if ($value->tinhtrang == 0) Đang tiến hành @else Đã kết thúc @endif
                            </li>
                            <li class="list-info-group-item">
                                <span>Thể loại</span> : 
                                @foreach ($truyen_theloai as $key => $value3)
                                    @if($value->matruyen == $value3->matruyen)
                                    &#160; <a href="{{url('/the-loai/'.$value3->duongdantheloai)}}" rel="category tag">{{$value3->tentheloai}}</a>  
                                    @endif
                                @endforeach
                            </li>
                            <li class="list-info-group-item">
                                <span>Lượt xem</span> : &#160; {{$value->luotxem}}
                            </li>
                            <li class="list-info-group-item">
                                @if(Auth::id())
                                    @if($theodoi)
                                        <span><a class="btn btn-danger" style="color: #fff;" href="{{url('/botheodoitruyen/'.$value->matruyen.'/'.Auth::user()->id)}}"><i class='bx bx-x'></i> Bỏ theo dõi</a></span> 
                                    @else
                                        <span><a class="btn btn-success" style="color: #fff;" href="{{url('/theodoitruyen/'.$value->matruyen.'/'.Auth::user()->id)}}"><i class='bx bxs-heart'></i> Theo dõi</a></span> 
                                    @endif
                                @else
                                    <span><a class="btn btn-success" style="color: #fff;" href="{{url('/login')}}"><i class='bx bxs-heart'></i> Theo dõi</a></span>
                                @endif
                                 &#160; {{$value->luottheodoi}} người đã theo dõi
                            </li>
                            <li class="list-info-group-item">
                                <a style="color: #fff;" href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$chap_dau->sochap)}}"><span class="btn btn-warning">Đọc từ đầu</span></a> &#160; 
                                <a style="color: #fff;" href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$chap_cuoi->sochap)}}"><span class="btn btn-warning">Đọc mới nhất</span></a>
                            </li>
                        </ul>
                        <div class="movie-trailer hidden"></div>
                    </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="halim_trailer"></div>
                <div class="clearfix"></div>
                <span class="label-content-truyen">Nội dung truyện<i class='bx bxs-chevron-right'></i></span>
                <div class="entry-content htmlwrap clearfix">
                    <div class="video-item halim-entry-box">
                        {{$value->noidungtruyen}}
                    </div>
                </div>
                <span class="label-content-truyen">Danh sách chương<i class='bx bxs-chevron-right'></i></span>
                <div class="entry-content htmlwrap clearfix">
                    <div class="video-item halim-entry-box">
                        <div style="display: flex; justify-content: space-between; align-content: flex-end; padding: 4px 10px; color: #ccc; font-size: 15px;">
                            <div>Chương</div>
                            <div>&#160;&#160;&#160;Cập nhật</div>
                            <div>Xem</div>
                        </div>
                        <div style="list-style: none; border: 1px solid #ccc; border-radius: 4px; max-height: 500px; overflow-y: auto;">
                            @foreach ($chap as $taptruyen)
                                @if ($taptruyen->matruyen==$value->matruyen)
                                    <li style="list-style: none; border-bottom: 1px dashed #ccc; color: #f5f5f5; display: flex; justify-content: space-between; margin: 0 10px; padding: 10px 10px 10px 0; color: #ccc; align-item: flex-end;">
                                        <div>
                                            <a style="color: #fff;" href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$taptruyen->sochap)}}" data-id="872171">Chapter {{$taptruyen->sochap}} {{$taptruyen->tenchap}}</a>
                                        </div>
                                        <div>{{\Carbon\Carbon::parse($taptruyen->ngaytaochap)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}</div>
                                        <div>{{$taptruyen->luotxemchap}}</div>
                                    </li>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <span class="label-content-truyen">Bình luận<i class='bx bxs-chevron-right'></i></span>
                <div class="entry-content htmlwrap clearfix">
                    <div class="video-item halim-entry-box">
                        <form  @if(Auth::id()) action="{{url('/thembinhluantruyen/'.$value->matruyen.'/'.Auth::user()->id)}}" @else action="{{url('/login')}}" @endif method="POST">
                            @csrf
                            <textarea id="autosize" style="width: 100%; resize: none; border-radius: 5px; overflow: hidden; color:#000; padding: 10px;" placeholder="nhập bình luận" name="binhluan" rows="3"></textarea>
                            <div style="display: flex; justify-content: space-between;">
                                <div></div>
                                <button class="btn btn-primary" type="submit">Gửi</button>
                            </div>
                        </form>
                    </div>
                </div>

                <section id="gotocomments" style="padding: 8px;">
                    @foreach($binhluan as $binhluans)
                        @if($binhluans->matruyen == $value->matruyen)
                            <div style="display: flex; margin: 10px;">
                                <div>
                                    @if($binhluans->image != null)
                                        <img style="width: 40px; height: 40px; max-width: none; border: 1px solid #ccc" src="{{asset('uploads/hoso/'.$binhluans->image)}}" alt="{{$binhluans->image}}">
                                    @else
                                        <img style="width: 40px; height: 40px; max-width: none; border: 1px solid #ccc" src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="">
                                    @endif
                                </div>
                                <i class='bx bx-chevrons-left' style="font-size: 20px; padding: 5px; margin-left: -10px;"></i>
                                <div style="margin-left: -10px; display: flex; flex-direction: column; border: 1px solid #ccc; padding: 10px; width: 100%">
                                    <div style="display: flex; border-bottom: 1px solid #ccc">
                                        <h5 style="font-weight:bold; color: #6092ff">{{$binhluans->name}}</h5> &#160;&#160;&#160;&#160;
                                        @if($binhluans->machap != null)
                                            @foreach($chap as $taptruyen2)
                                                @if($taptruyen2->machap == $binhluans->machap)
                                                    <h5><a href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$taptruyen2->sochap)}}">Chapter {{$taptruyen2->sochap}}</a></h5>
                                                @endif
                                            @endforeach
                                        @else
                                        <h5></h5>
                                        @endif
                                    </div>
                                    @auth
                                        @if ($binhluans->nguoidangtruyen == Auth::user()->id || Auth::user()->permission == 1)
                                            <div class="hide-comment-truyen" onclick="anbinhluan({{$binhluans->mabinhluan}})"><i class='bx bx-low-vision'></i>Ẩn bình luận</div>
                                        @endif
                                    @endauth
                                    <textarea id="autosize" readonly onclick="auto_grow(this)" style="width: 100%; resize: none; overflow: hidden; color:#fff; margin-top: 10px; background: none; border: none;" rows="1">{{$binhluans->noidungbinhluan}}</textarea>
                                    <div style="display: flex; justify-content:space-between;">
                                        <span onclick="showreply({{$binhluans->mabinhluan}})">
                                            <i class="fa fa-comment"></i> Trả lời
                                        </span>
                                        <abbr>
                                            <i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($binhluans->ngaybinhluan)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}
                                        </abbr>
                                    </div>
                                    @auth
                                        <form id="showreply{{$binhluans->mabinhluan}}" style="display: none;" action="{{url('/traloibinhluantruyen/'.$binhluans->id.'/'.$binhluans->mabinhluan.'/'.Auth::user()->id)}}" method="POST">
                                            @csrf
                                            <textarea id="autosize" style="width: 100%; resize: none; border-radius: 5px; overflow: hidden; color:#000; padding: 10px;" placeholder="nhập trả lời" name="binhluan" rows="3"></textarea>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div></div>
                                                <button class="btn btn-primary" type="submit">Gửi</button>
                                            </div>
                                        </form>
                                    @else
                                        <div id="showreply{{$binhluans->mabinhluan}}" style="display: none;">
                                            @csrf
                                            <textarea readonly id="autosize" style="width: 100%; resize: none; border-radius: 5px; overflow: hidden; color:#000; padding: 10px;" placeholder="Đăng nhập để trả lời" name="binhluan" rows="1"></textarea>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div></div>
                                                <a href="{{url('/login')}}"><button class="btn btn-primary">Đăng nhập</button></a>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                            @foreach($traloibinhluan as $traloibinhluans)
                                @if ($traloibinhluans->mabinhluan == $binhluans->mabinhluan)
                                    <div style="display: flex; margin: 10px; margin-left: 60px;">
                                        <div>
                                            @foreach($user as $userss)
                                                @if($userss->id == $traloibinhluans->uid_traloi)
                                                    @if($userss->image != null)
                                                        <img style="width: 40px; height: 40px; max-width: none; border: 1px solid #ccc" src="{{asset('uploads/hoso/'.$userss->image)}}" alt="{{$userss->image}}">
                                                    @else
                                                        <img style="width: 40px; height: 40px; max-width: none; border: 1px solid #ccc" src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="">
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <i class='bx bx-chevrons-left' style="font-size: 20px; padding: 5px; margin-left: -10px;"></i>
                                        <div style="margin-left: -10px; display: flex; flex-direction: column; border: 1px solid #ccc; padding: 10px; width: 100%">
                                            <div style="display: flex; border-bottom: 1px solid #ccc">
                                                @foreach($user as $usersss)
                                                    @if($usersss->id == $traloibinhluans->uid_traloi)
                                                        <h5 style="font-weight:bold; color: #6092ff">{{$usersss->name}}</h5> 
                                                    @endif
                                                @endforeach
                                                &#160;
                                                <h5 style="font-weight:bold; color: #6092ff">
                                                    <i style="font-size :bold; color: #6092ff;" class='bx bx-chevrons-right'></i>
                                                    @foreach($user as $users)
                                                        @if ($users->id == $traloibinhluans->id)
                                                            {{$users->name}}
                                                        @endif
                                                    @endforeach
                                                </h5>
                                            </div>
                                            @auth
                                                @if ($binhluans->nguoidangtruyen == Auth::user()->id || Auth::user()->permission == 1)
                                                    <div class="hide-comment-truyen" onclick="antraloi({{$traloibinhluans->matraloi}})"><i class='bx bx-low-vision'></i>Ẩn bình luận</div>
                                                @endif
                                            @endauth
                                            <textarea id="autosize" readonly onclick="auto_grow(this)" style="width: 100%; resize: none; overflow: hidden; color:#fff; margin-top: 10px; background: none; border: none;" rows="1">{{$traloibinhluans->noidungtraloi}}</textarea>
                                            <div style="display: flex; justify-content: space-between;">
                                                <span onclick="showreplys({{$traloibinhluans->matraloi}})">
                                                    <i class="fa fa-comment"></i> Trả lời
                                                </span>
                                                <abbr>
                                                    <i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($traloibinhluans->ngaytraloi)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}
                                                </abbr>
                                            </div>
                                            @auth
                                                <form id="showreplys{{$traloibinhluans->matraloi}}" style="display: none;" action="{{url('/traloibinhluantruyen/'.$traloibinhluans->uid_traloi.'/'.$binhluans->mabinhluan.'/'.Auth::user()->id)}}" method="POST">
                                                    @csrf
                                                    <textarea id="autosize" style="width: 100%; resize: none; border-radius: 5px; overflow: hidden; color:#000; padding: 10px;" placeholder="nhập trả lời" name="binhluan" rows="3"></textarea>
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <div></div>
                                                        <button class="btn btn-primary" type="submit">Gửi</button>
                                                    </div>
                                                </form>
                                            @else
                                                <div id="showreplys{{$traloibinhluans->matraloi}}" style="display: none;">
                                                    @csrf
                                                    <textarea readonly id="autosize" style="width: 100%; resize: none; border-radius: 5px; overflow: hidden; color:#000; padding: 10px;" placeholder="Đăng nhập để trả lời" name="binhluan" rows="1"></textarea>
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <div></div>
                                                        <a href="{{url('/login')}}"><button class="btn btn-primary">Đăng nhập</button></a>
                                                    </div>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    <div class="text-center">
                        {!! $binhluan->links("pagination::bootstrap-4") !!}
                    </div>
                </section>
                
            </div>
        </section>

        @include('truyenlienquan')

        </main>
    @endforeach

    @include('topview')
 </div>

@endsection
