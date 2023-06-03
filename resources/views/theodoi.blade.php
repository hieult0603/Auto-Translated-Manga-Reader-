@extends('welcome')

@section('content')

<div id="halim_related_movies-2xx" class="wrap-slider">
<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
    <section id="halim-advanced-widget-2">
        <div class="xuongdong"></div>
        <span class="label-content-truyen">Truyện đang theo dõi<i class='bx bxs-chevron-right'></i></span>
        <div id="halim-advanced-widget-2-ajax-box" class="halim_box" style="display: flex; flex-wrap: wrap;">
            @foreach ($theodoi as $item)
                <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                    <div class="item" style="margin: 6px;">
                        <figure class="clearfix">
                            <div class="image">
                                <a title="{{$item->tentruyen}}" href="{{url('/truyen-tranh/'.$item->duongdantruyen)}}">
                                    <img style="height: 200px; min-height: 200px; border-radius: 4px; border: 1px solid #ccc;" src="{{asset('uploads/truyen/'.$item->hinhnen)}}" class="lazy" data-original="{{asset('uploads/truyen/'.$item->hinhnen)}}" alt="{{$item->tentruyen}}">
                                </a>
                                <a href="{{url('/truyen-tranh/'.$item->duongdantruyen.'/'.$item->sochap)}}"><span style="position: absolute; z-index: 999; top: 6px; left: 6px; background: #000000b9; width: calc(100% - 12px); padding: 2px 0; color: #fff; border-top-left-radius: 4px; border-top-right-radius: 4px; text-align: center; font-size: 13px; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-top: 1px solid #ccc;">Đọc tiếp chapter {{$item->sochap}}</span></a>
                                
                                <div class="view clearfix" style="position: relative; margin-top: -26px; background: #000000b9; padding: 2px; display: flex; justify-content: space-evenly; align-items: center; border-left: 1px solid #ccc; border-right: 1px solid #ccc; border-bottom: 1px solid #ccc; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                                    <i class="fa fa-eye"></i> {{$item->luotxem}}
                                    <i class="fa fa-comment"></i> {{$item->luotbinhluan}}
                                    <i class="fa fa-heart"></i> {{$item->luottheodoi}}
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                <div></div>
                                <a href="{{url('/botheodoitruyen/'.$item->matruyen.'/'.Auth::user()->id)}}"><span style="background: #ff0000ca; color: #fff; padding: 2px;">Bỏ theo dõi</span> </a>
                            </div>
                            <figcaption style="min-height: 80px; margin-top: -15px;">
                                <h3 class="tentruyen">
                                    <a style="font-size: 14px;" class="jtip" data-jtip="#truyen-tranh-57380" href="{{url('/truyen-tranh/'.$item->duongdantruyen)}}">{{$item->tentruyen}}</a>
                                </h3>
                                <div style="position: relative; overflow-y: hidden; max-height: 78px;">
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
            {!! $theodoi->links("pagination::bootstrap-4") !!}
        </div>
    </section>
   <div class="clearfix"></div>
   
</main>

@include('aside_lichsu')
@include('topview')

@endsection
