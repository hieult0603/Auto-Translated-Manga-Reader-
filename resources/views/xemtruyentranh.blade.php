@extends('welcome3')
@section('content')

<div class="reading-detail box_doc" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">

    @foreach ($chap as $key => $value)
        <div class="page-chapter" style="padding: 10px;">
            <a href="{{url('/')}}">trang chủ</a> »
            <a href="{{url('/truyen-tranh/'.$value->duongdantruyen)}}">{{$value->tentruyen}}</a> »
            <a>Chapter {{$value->sochap}}</a>
        </div>
        Sử dụng mũi tên trái (←) hoặc phải (→) để chuyển chapter
        <div class="page-chapter" id="showstickys" style="">
            <div style="z-index: auto; position: static; top: auto; display: flex; justify-content: center; align-items: center;">
                <a style="font-size: 24px; color: #ff0000; margin: 0 5px 0 10px;" href="{{url('/')}}" title="Trang chủ"><i class="fa fa-home"></i></a>
                <a style="font-size: 24px; color: #ff0000; margin: 0 10px 0 5px;" href="{{url('/truyen-tranh/'.$value->duongdantruyen.'#nt_listchapter')}}" title="{{$value->tentruyen}}"><i class="fa fa-list"></i></a>
                @if($chaptruoc)
                    <a href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$chaptruoc->sochap)}}" class="btn btn-success"><i class="fa fa-chevron-left"></i></a>
                @else
                    <a style="opacity: 0.5;" class="btn btn-success"><i class="fa fa-chevron-left"></i></a>
                @endif

                <select name="luachontaptruyen" class="btn luachontaptruyen" style="margin: 0 5px 0 5px;">
                    @foreach($danhsachchap as $danhsachchaps)
                        @if($danhsachchaps->duongdantruyen == $value->duongdantruyen)
                            <option @if($danhsachchaps->machap == $value->machap) selected @endif value="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$danhsachchaps->sochap)}}">Chapter {{$danhsachchaps->sochap}}</option>
                        @endif
                    @endforeach
                </select>
                
                @if($chapsau)
                    <a href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$chapsau->sochap)}}" class="btn btn-success"><i class="fa fa-chevron-right"></i></a>
                @else
                    <a style="opacity: 0.5;" class="btn btn-success"><i class="fa fa-chevron-right"></i></a>
                @endif
                @if(Auth::id())
                    @if($theodoi)
                        <a style="margin: 0 10px 0 10px;" href="{{url('/botheodoitruyen/'.$value->matruyen.'/'.Auth::user()->id)}}" class="btn btn-danger botheodoi"><i class="fa fa-heart"></i> <span class="textbotheodoi">Bỏ theo dõi</span></a>
                    @else
                        <a style="margin: 0 10px 0 10px;" href="{{url('/theodoitruyen/'.$value->matruyen.'/'.Auth::user()->id)}}" class="btn btn-success botheodoi"><i class="fa fa-heart"></i> <span class="textbotheodoi">Theo dõi</span></a>
                    @endif
                @else
                    <a style="margin: 0 10px 0 10px;" href="{{url('/login')}}" class="btn btn-success botheodoi"><i class="fa fa-heart"></i> <span class="textbotheodoi">Theo dõi</span></a>
                @endif

                <select name="dichtruyen" class="btn dichtruyen" style="margin: 0 5px 0 5px;">
                    <option>Vietnamese</option>
                    <option>English</option>
                    <option>Japan</option>
                    <option>Chinese</option>
                </select>
                 <select name="test" class="btn test" style="margin: 0 5px 0 5px;">
                    <option id="name-output"></option>
                </select>
                <div id="name-output"></div>
            </div>
        </div>
        @foreach($anhchap as $key => $anhchaps)
            @if($anhchaps->machap == $value->machap)
                <div class="page-chapter" id="image-container">
                    <img alt="{{$value->tentruyen}} - Trang {{$key}}" data-index="1" src="{{asset('uploads/chap/'.$anhchaps->hinhanh)}}" data-original="{{asset('uploads/chap/'.$anhchaps->hinhanh)}}">
                </div>
            @endif
        @endforeach
        <div class="page-chapter btn">
            @if($chaptruoc)
                <a href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$chaptruoc->sochap)}}" class="btn btn-success"><i class="fa fa-chevron-left"></i> Chap trước</a>
            @else
                <a style="opacity: 0.5;" class="btn btn-success"><i class="fa fa-chevron-left"></i> Chap trước</a>
            @endif
            @if($chapsau)
                <a href="{{url('/truyen-tranh/'.$value->duongdantruyen.'/'.$chapsau->sochap)}}" class="btn btn-success">Chap sau <i class="fa fa-chevron-right"></i></a>
            @else
                <a style="opacity: 0.5;" class="btn btn-success">Chap sau <i class="fa fa-chevron-right"></i></a>
            @endif
        </div>
        <div class="page-chapter" style="padding: 10px;">
            <a href="{{url('/')}}">trang chủ</a> »
            <a href="{{url('/truyen-tranh/'.$value->duongdantruyen)}}">{{$value->tentruyen}}</a> »
            <a>Chapter {{$value->sochap}}</a>
        </div>
    @endforeach

    <div style="width: 100%; padding: 10px;">
        <span class="label-content-truyen">Bình luận<i class='bx bxs-chevron-right'></i></span>
    </div>
    <div style="width: 100%; padding: 10px;">
        <div class="video-item halim-entry-box">
            <form @if(Auth::id()) action="{{url('/thembinhluanchap/'.$value->matruyen.'/'.$value->machap.'/'.Auth::user()->id)}}" @else action="{{url('/login')}}" @endif method="POST">
                @csrf
                <textarea id="autosize" style="width: 100%; resize: none; border-radius: 5px; overflow: hidden; color:#000; padding: 10px;" placeholder="nhập bình luận" name="binhluan" rows="3"></textarea>
                <div style="display: flex; justify-content: space-between;">
                    <div></div>
                    <button class="btn btn-primary" type="submit">Gửi</button>
                </div>
            </form>
        </div>
    </div>
    <div class="page-chapter" style="width: 100%;" id="gotocomments">
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
                                @foreach($chaps as $taptruyen2)
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
                                <div class="hide-comment-chap" onclick="anbinhluan({{$binhluans->mabinhluan}})"><i class='bx bx-low-vision'></i>Ẩn bình luận</div>
                            @endif
                        @endauth
                        <textarea id="autosize" readonly onclick="auto_grow(this)" style="width: 100%; resize: none; overflow: hidden; color:#fff; margin-top: 10px; background: none; border: none;" rows="1">{{$binhluans->noidungbinhluan}}</textarea>
                        <div style="display: flex; justify-content: space-between;">
                            <span onclick="showreply({{$binhluans->mabinhluan}})">
                                <i class="fa fa-comment"></i> Trả lời
                            </span>
                            <abbr>
                                <i class="fa fa-clock-o"></i> {{\Carbon\Carbon::parse($binhluans->ngaybinhluan)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}
                            </abbr>
                        </div>
                        @auth
                            <form id="showreply{{$binhluans->mabinhluan}}" style="display: none;" action="{{url('/traloibinhluanchap/'.$binhluans->id.'/'.$binhluans->mabinhluan.'/'.$value->sochap.'/'.Auth::user()->id)}}" method="POST">
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
                                        <div class="hide-comment-chap" onclick="antraloi({{$traloibinhluans->matraloi}})"><i class='bx bx-low-vision'></i>Ẩn bình luận</div>
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
                                    <form id="showreplys{{$traloibinhluans->matraloi}}" style="display: none;" action="{{url('/traloibinhluanchap/'.$traloibinhluans->uid_traloi.'/'.$binhluans->mabinhluan.'/'.$value->sochap.'/'.Auth::user()->id)}}" method="POST">
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
    </div>

</div>
<script>
    $('.dichtruyen').change(function(){
        var name = $(this).find(':selected').text();

        var images = ('#image-container');

        var imageUrls = [];

        images.each(function() {
            var imageUrl = $(this).attr('src');
            imageUrls.push(imageUrl);
        });
        
        console.log(imageUrls);

        $.ajax({
        type: "POST",
        url: "http://127.0.0.1:5000/model",
        data: { 
            name: name
            JSON.stringify({ imageUrls: imageUrls })
        },
        success: function(response){
            // Handle the response from your Flask function
            var name = response.name;
            console.log("Received name:", name);
            // Display the name on the webpage
            $("#name-output").text(name);
        },
        error: function(xhr, status, error){
            // Handle any errors that occur during the AJAX request
            console.log(error);
        }
        });
    });
</script>
@endsection