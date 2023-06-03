
<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
    <div class="xuongdong"></div>
    <div style="border: 1px solid #ccc; margin-bottom: 15px; margin-top: 15px;">
        <ul class="nav nav-tabs">
            <li class="active title-tabs"><a class="title-tabs-name" data-toggle="tab" href="#home">Top Tháng</a></li>
            <li class="title-tabs"><a class="title-tabs-name" data-toggle="tab" href="#menu1">Top Ngày</a></li>
            <li class="title-tabs"><a class="title-tabs-name" data-toggle="tab" href="#menu2">Top All</a></li>
        </ul>
        
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                @if ($checktopthang)
                    @foreach ($topthang as $key => $topthangs)
                        <div class="topview-content">
                            <h5 style="@if($key == 0) color: #8b8bff; @endif @if($key == 1) color: #87ff6c; @endif @if($key == 2) color: #fc4848; @endif">0{{$key + 1}}</h5>
                            <a class="aimg" href="{{url('/truyen-tranh/'.$topthangs->duongdantruyen)}}">
                                <img src="{{asset('uploads/truyen/'.$topthangs->hinhnen)}}" alt="{{$topthangs->tentruyen}}">
                            </a>
                            <div class="topview-content-col">
                                <a class="topview-content-col-name" href="{{url('/truyen-tranh/'.$topthangs->duongdantruyen)}}">{{$topthangs->tentruyen}}</a>
                                <div class="topview-content-col-row">
                                    @foreach($newChapForTopMonth as $key => $newChapForTopMonths)
                                        @if($newChapForTopMonths->matruyen == $topthangs->matruyen)
                                            <a href="{{url('/truyen-tranh/'.$topthangs->duongdantruyen.'/'.$newChapForTopMonths->sochap)}}" class="topview-content-col-new">Chapter {{$newChapForTopMonths->sochap}}</a>
                                        @endif
                                    @endforeach
                                    <div class="topview-content-col-row"><i class='bx bx-show-alt'></i>{{$topthangs->luotxemthang}}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div id="menu1" class="tab-pane fade">
                @if ($checktopngay)
                    @foreach($topngay as $key => $topngays)
                        <div class="topview-content">
                            <h5 style="@if($key == 0) color: #8b8bff; @endif @if($key == 1) color: #87ff6c; @endif @if($key == 2) color: #fc4848; @endif">0{{$key + 1}}</h5>
                            <a class="aimg" href="{{url('/truyen-tranh/'.$topngays->duongdantruyen)}}">
                                <img src="{{asset('uploads/truyen/'.$topngays->hinhnen)}}" alt="{{$topngays->tentruyen}}">
                            </a>
                            <div class="topview-content-col">
                                <a class="topview-content-col-name" href="{{url('/truyen-tranh/'.$topngays->duongdantruyen)}}">{{$topngays->tentruyen}}</a>
                                <div class="topview-content-col-row">
                                    @foreach($newChapForTopDay as $key => $newChapForTopDays)
                                        @if($newChapForTopDays->matruyen == $topngays->matruyen)
                                            <a href="{{url('/truyen-tranh/'.$topngays->duongdantruyen.'/'.$newChapForTopDays->sochap)}}" class="topview-content-col-new">Chapter {{$newChapForTopDays->sochap}}</a>
                                        @endif
                                    @endforeach
                                    <div class="topview-content-col-row"><i class='bx bx-show-alt'></i>{{$topngays->luotxemngay}}</div>
                                </div>
                             </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div id="menu2" class="tab-pane fade">
                @foreach($topall as $key => $topalls)
                    <div class="topview-content">
                        <h5 style="@if($key == 0) color: #8b8bff; @endif @if($key == 1) color: #87ff6c; @endif @if($key == 2) color: #fc4848; @endif">0{{$key + 1}}</h5>
                        <a class="aimg" href="{{url('/truyen-tranh/'.$topalls->duongdantruyen)}}">
                            <img src="{{asset('uploads/truyen/'.$topalls->hinhnen)}}" alt="{{$topalls->tentruyen}}">
                        </a>
                        <div class="topview-content-col">
                            <a class="topview-content-col-name" href="{{url('/truyen-tranh/'.$topalls->duongdantruyen)}}">{{$topalls->tentruyen}}</a>
                            <div class="topview-content-col-row">
                                @foreach($newChapForTopAll as $key => $newChapForTopAlls)
                                    @if($newChapForTopAlls->matruyen == $topalls->matruyen)
                                        <a href="{{url('/truyen-tranh/'.$topalls->duongdantruyen.'/'.$newChapForTopAlls->sochap)}}" class="topview-content-col-new">Chapter {{$newChapForTopAlls->sochap}}</a>
                                    @endif
                                @endforeach
                                <div class="topview-content-col-row"><i class='bx bx-show-alt'></i>{{$topalls->luotxem}}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</aside>
