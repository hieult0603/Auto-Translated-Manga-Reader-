
<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
        <div class="xuongdong"></div>
        <span class="label-content-truyen">Bình luận<i class='bx bxs-chevron-right'></i></span>
       <div class="page-chapter" style="width: 100%;">
        @foreach($binhluan as $binhluans)
                <div style="display: flex; margin-top: 10px;">
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
                            <h5 style="font-weight:bold; color: #6092ff">{{$binhluans->name}}</h5> &#160;
                            <h5><a style="color: #ffed4d" href="{{url('/truyen-tranh/'.$binhluans->duongdantruyen)}}">{{$binhluans->tentruyen}}</a></h5>&#160;
                            @if($binhluans->machap != null)
                                @foreach($chap as $taptruyen2)
                                    @if($taptruyen2->machap == $binhluans->machap)
                                        <h5><a href="{{url('/truyen-tranh/'.$binhluans->duongdantruyen.'/'.$taptruyen2->sochap)}}">Chapter {{$taptruyen2->sochap}}</a></h5>
                                    @endif
                                @endforeach
                            @else
                            <h5></h5>
                            @endif
                        </div>
                        @auth
                            @if ($binhluans->nguoidangtruyen == Auth::user()->id || Auth::user()->permission == 1)
                                <div class="hide-comment" onclick="anbinhluan({{$binhluans->mabinhluan}})"><i class='bx bx-low-vision'></i>Ẩn bình luận</div>
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
                        <div style="display: flex; margin: 10px 0 10px 10px; margin-left: 50px;">
                            <div>
                                @foreach($user as $users)
                                    @if ($users->id == $traloibinhluans->uid_traloi)
                                        @if($users->image != null)
                                            <img style="width: 40px; height: 40px; max-width: none; border: 1px solid #ccc" src="{{asset('uploads/hoso/'.$users->image)}}" alt="{{$users->image}}">
                                        @else
                                            <img style="width: 40px; height: 40px; max-width: none; border: 1px solid #ccc" src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="">
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <i class='bx bx-chevrons-left' style="font-size: 20px; padding: 5px; margin-left: -10px;"></i>
                            <div style="margin-left: -10px; display: flex; flex-direction: column; border: 1px solid #ccc; padding: 10px; width: 100%">
                                <div style="display: flex; border-bottom: 1px solid #ccc">
                                    @foreach($user as $userss)
                                        @if($userss->id == $traloibinhluans->uid_traloi)
                                            <h5 style="font-weight:bold; color: #6092ff">{{$userss->name}}</h5> &#160;
                                        @endif
                                    @endforeach
                                    <h5 style="font-weight:bold; color: #6092ff">
                                        <i style="font-size :bold; color: #6092ff;" class='bx bx-chevrons-right'></i>
                                        @foreach($user as $usersss)
                                            @if ($usersss->id == $traloibinhluans->id)
                                                {{$usersss->name}}
                                            @endif
                                        @endforeach
                                    </h5>
                                </div>
                                @auth
                                    @if ($binhluans->nguoidangtruyen == Auth::user()->id || Auth::user()->permission == 1)
                                        <div class="hide-comment" onclick="antraloi({{$traloibinhluans->matraloi}})"><i class='bx bx-low-vision'></i>Ẩn bình luận</div>
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
        @endforeach
    </div>
</aside>