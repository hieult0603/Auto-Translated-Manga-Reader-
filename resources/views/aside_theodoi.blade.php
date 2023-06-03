@if(Auth::id())
    <aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
        <div id="halim_tab_popular_videos-widget-7" class="widget halim_tab_popular_videos-widget">
            <div class="section-bar clearfix">
                <div class="section-title">
                    <span>Truyện đang theo dõi</span>
                    <ul class="halim-popular-tab" role="tablist">
                        <li role="presentation" class="active">
                            <a href="{{url('/theo-doi/'.Auth::user()->id)}}">Xem tất cả</a>
                        </li>
                    </ul>
                </div>
            </div>
            <section class="tab-content" style="max-height: 429px; overflow-y: hidden;">
                <div role="tabpanel" class="tab-pane active halim-ajax-popular-post">
                    <div class="halim-ajax-popular-post-loading hidden"></div>
                    <div id="halim-ajax-popular-post" class="popular-post">
                        @foreach($truyen_theodoi as $theodoi)
                            @if($theodoi->id == Auth::user()->id)
                                @foreach($truyen_tat as $value6)
                                    @if($value6->matruyen == $theodoi->matruyen)
                                        <div class="item post-37176">
                                            <a href="{{url('/truyen-tranh/'.$value6->duongdantruyen)}}" title="{{$value6->tentruyen}}">
                                                <div class="item-link">
                                                    <img src="{{asset('uploads/truyen/'.$value6->hinhnen)}}" class="lazy post-thumb" alt="{{$value6->tentruyen}}" title="{{$value6->tentruyen}}" />
                                                </div>
                                                <p class="title">{{$value6->tentruyen}}</p>
                                            </a>
                                            @foreach($chapmoi as $chapmois)
                                                @if($chapmois->matruyen == $theodoi->matruyen)
                                                    <div class="viewsCount" style="color: #ccc; display: flex;">
                                                        <a class="xemchapmoi" style="color: #ccc;" href="{{url('/truyen-tranh/'.$value6->duongdantruyen.'/'.$chapmois->sochap)}}">Chapter {{$chapmois->sochap}}</a> &#160;&#160; 
                                                        <div class="xemngaychapmoi">{{\Carbon\Carbon::parse($chapmois->ngaytaochap)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}</div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if($theodoi->sochap != null)
                                                <div class="viewsCount"><a style="color: #ccc;" href="{{url('/truyen-tranh/'.$value6->duongdantruyen.'/'.$theodoi->sochap)}}">Đọc tiếp Chapter {{$theodoi->sochap}}</a></div>
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