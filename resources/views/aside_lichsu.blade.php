@if(Auth::id())
    
<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
        <div class="section-bar clearfix">
            <div class="section-title">
                <span>Lịch sử đọc truyện</span>
                <ul class="halim-popular-tab">
                    <li class="active">
                        <a href="{{url('/lich-su/'.Auth::user()->id)}}">Xem tất cả</a>
                    </li>
                </ul>
            </div>
        </div>
        <section class="tab-content" style="max-height: 429px; overflow-y: hidden;">
            <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                <div class="halim-ajax-popular-post-loading hidden"></div>
                <div id="halim-ajax-popular-post" class="popular-post">
                    @foreach($truyen_lichsu as $lichsu)
                        @if($lichsu->id == Auth::user()->id)
                            @foreach($truyen_tat as $value7)
                                @if($value7->matruyen == $lichsu->matruyen)
                                    <div class="item post-37176">
                                        <a href="{{url('/truyen-tranh/'.$value7->duongdantruyen)}}" title="{{$value7->tentruyen}}">
                                            <div class="item-link">
                                                <img src="{{asset('uploads/truyen/'.$value7->hinhnen)}}" class="lazy post-thumb" alt="{{$value7->tentruyen}}" title="{{$value7->tentruyen}}" />
                                            </div>
                                            <p class="title">{{$value7->tentruyen}}</p>
                                        </a>
                                        @foreach($chapmoi as $chapmois)
                                            @if($chapmois->matruyen == $lichsu->matruyen)
                                                <div class="viewsCount" style="color: #ccc; display: flex;">
                                                    <a class="xemchapmoi" style="color: #ccc;" href="{{url('/truyen-tranh/'.$value7->duongdantruyen.'/'.$chapmois->sochap)}}">Chapter {{$chapmois->sochap}}</a> &#160;&#160; 
                                                    <div class="xemngaychapmoi">{{\Carbon\Carbon::parse($chapmois->ngaytaochap)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}</div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if($lichsu->sochap != null)
                                            <div class="viewsCount" style="color: #9d9d9d;"><a href="{{url('/truyen-tranh/'.$value7->duongdantruyen.'/'.$lichsu->sochap)}}">Đọc tiếp Chapter {{$lichsu->sochap}}</a></div>
                                        @endif
                                        <div style="float: left;">
                                            <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                                            <span style="width: 0%"></span>
                                            </span>
                                        </div>
                                    </div> 
                                @endif 
                            @endforeach 
                        @endif
                    @endforeach          
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
    </div>
</aside>
@endif