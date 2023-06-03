@extends('welcome')

@section('content')

<div id="halim_related_movies-2xx" class="wrap-slider">
    <div class="xuongdong"></div>
    <span class="label-content-truyen">Truyện đề cử<i class='bx bxs-chevron-right'></i></span>
<div id="halim_related_movies-2" class="owl-carousel owl-theme related-film" style="padding: 8px;">
    @foreach($truyen_hot as $hot)
    <article class="thumb grid-item post-38498">
        <div class="halim-item">
            <a class="halim-thumb" href="{{url('/truyen-tranh/'.$hot->duongdantruyen)}}" title="{{$hot->tentruyen}}">
                <figure><img style="height: 220px; min-height: 220px; border: 1px solid #ccc;" class="lazy img-responsive" src="{{asset('uploads/truyen/'.$hot->hinhnen)}}" alt="{{$hot->tentruyen}}" title="{{$hot->tentruyen}}"></figure>
            </a>
        </div>
        <div style="position:absolute; bottom:0; background:#000000bd; display:flex; flex-direction:column; width:100%; align-items:center; padding: 5px; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc;">
            <a style="color:#fff; text-overflow: ellipsis; -webkit-box-orient: vertical; -webkit-line-clamp: 1; display: -webkit-box; overflow: hidden;" href="{{url('/truyen-tranh/'.$hot->duongdantruyen)}}">{{$hot->tentruyen}}</a>
            @foreach($chap_hot as $chaps)
                @if($chaps->matruyen == $hot->matruyen)
                    <div style="display: flex; align-items: center; width: 100%; justify-content: space-around; white-space:nowrap;">
                        <a style="color: #fff; font-size:13px;" href="{{url('/truyen-tranh/'.$hot->duongdantruyen.'/'.$chaps->sochap)}}">Chapter {{$chaps->sochap}}</a>
                        <div style="font-size: 11px;">{{\Carbon\Carbon::parse($chaps->ngaytaochap)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}</div>
                    </div>
                @endif
            @endforeach
        </div>
    </article>
    @endforeach
</div>
<script>
    jQuery(document).ready(function($) {            
    var owl = $('#halim_related_movies-2');
    owl.owlCarousel({loop: true,margin: 8,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="bx bxs-chevron-left"></i>', '<i class="bx bxs-chevron-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 720: {items:4},960: {items:5},1200: {items: 6}}})});
</script>
</div>
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
    <section id="halim-advanced-widget-2">
        <span class="label-content-truyen">Truyện mới cập nhật<i class='bx bxs-chevron-right'></i></span>
        <div id="halim-advanced-widget-2-ajax-box" class="halim_box" style="display: flex; flex-wrap: wrap;">
            @foreach ($truyen as $item)
                <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                    <div class="item" style="margin: 6px;">
                        <figure class="clearfix">
                            <div class="image">
                                <a title="{{$item->tentruyen}}" href="{{url('/truyen-tranh/'.$item->duongdantruyen)}}">
                                    <img style="height: 200px; min-height: 200px; border-radius: 4px; border: 1px solid #ccc;" src="{{asset('uploads/truyen/'.$item->hinhnen)}}" class="lazy" data-original="{{asset('uploads/truyen/'.$item->hinhnen)}}" alt="{{$item->tentruyen}}">
                                </a>
                                <div class="view clearfix" style="position: relative; margin-top: -26px; background: #000000b9; padding: 2px; display: flex; justify-content: space-evenly; align-items: center; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                    <i class="fa fa-eye"></i> {{$item->luotxem}} 
                                    <i class="fa fa-comment"></i> {{$item->luotbinhluan}} 
                                    <i class="fa fa-heart"></i> {{$item->luottheodoi}} 
                                </div>
                            </div>
                            <figcaption style="min-height: 80px; margin-top: -15px; width: 100%;">
                                <h3 class="tentruyen">
                                    <a style="font-size: 14px;" class="jtip" data-jtip="#truyen-tranh-57380" href="{{url('/truyen-tranh/'.$item->duongdantruyen)}}">{{$item->tentruyen}}</a>
                                </h3>
                                <div style="position: relative; overflow-y: hidden; max-height: 78px; width: 100%;">
                                    @foreach($chap as $taptruyen)
                                        @if($item->matruyen==$taptruyen->matruyen)
                                            <h5 class="chapter">
                                                <a class="sochaptruyen" style="color: #fff;" data-id="871640" href="{{url('/truyen-tranh/'.$item->duongdantruyen.'/'.$taptruyen->sochap)}}" title="{{$item->tentruyen.' tập '.$taptruyen->sochap}}">Chapter {{$taptruyen->sochap}}</a>
                                                <span class="ngaycapnhatchap" style="color: #ccc;">{{\Carbon\Carbon::parse($taptruyen->ngaytaochap)->diffForHumans(\Carbon\Carbon::now('Asia/Ho_Chi_Minh'))}}</span>
                                            </h5>
                                        @endif
                                    @endforeach
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="text-center">
            {!! $truyen->links("pagination::bootstrap-4") !!}
        </div>
    </section>
   <div class="clearfix"></div>
   
</main>

@include('aside_theodoi')
@include('aside_lichsu')
@include('topview')
@include('binhluan')

@endsection
