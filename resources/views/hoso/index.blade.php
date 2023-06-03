@extends('welcome')

@section('content')

<main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
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
    <section id="halim-advanced-widget-2">
        <form action="{{url('/capnhathoso/'.Auth::user()->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <div class="m-4">
                    @if (Auth::user()->image)
                    <img style="height: 200px; width: 200px; border-radius: 50px; padding: 5px;" src="{{asset('/uploads/hoso/'.Auth::user()->image)}}" alt="image">
                    @else
                    <img style="height: 200px; width: 200px; border-radius: 50px; padding: 5px;" src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="image">
                    @endif
                    <div class="m-2">
                        <label class="form-label">Chọn ảnh</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="">
                    <div class="m-4">
                        <label class="form-label">Tên</label>
                        <input name="ten" type="text" class="form-control" value="{{Auth::user()->name}}">
                    </div>
                    <div class="m-4">
                        <label class="form-label">Email</label>
                        <label class="form-control">{{Auth::user()->email}}</label>
                    </div>
                    <button type="submit" class="btn btn-primary m-2 w-25">Cập nhật hồ sơ</button>
                </div>
            </div>
        </form>
    </section>
   <div class="clearfix"></div>
</main>

@endsection
