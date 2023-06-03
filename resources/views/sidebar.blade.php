<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="{{asset('resources/css/app.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="https://res.cloudinary.com/v-network/image/upload/v1663523751/favicon_h5xid7.ico">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>QUẢN LÝ TRUYỆN MỚI</title>
   </head>
    <body>
    <div class="sidebar close">
        <div class="logo-details">
        <a href="{{ url('/') }}">
            <img class="p-2" style="width:60px; height:60px" src="https://res.cloudinary.com/v-network/image/upload/v1663523751/favicon_h5xid7.ico" alt="icon truyen moi">
        </a>
        <span class="logo_name"><img src="https://res.cloudinary.com/v-network/image/upload/v1656476023/logo-truyenmoi_q4nkw1.png" alt="logo truyen moi"></span>
        </div>
        <ul class="nav-links">
        <li>
            <a href="{{ url('/dashboard') }}">
                <i class='bx bxs-home'></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
            <li><a class="link_name" href="{{ url('/dashboard') }}">Dashboard</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/theloai') }}">
                <i class='bx bx-category'></i>
                <span class="link_name">Thể loại</span>
            </a>
            <ul class="sub-menu blank">
            <li><a class="link_name" href="{{ url('/theloai') }}">Thể loại</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/nguoidung') }}">
                <i class='bx bxs-user'></i>
                <span class="link_name">Người dùng</span>
            </a>
            <ul class="sub-menu blank">
            <li><a class="link_name" href="{{ url('/nguoidung') }}">Người dùng</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
            <a href="{{ url('/truyen') }}">
                <i class='bx bx-book-open'></i>
                <span class="link_name">Truyện</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="{{ url('/truyen') }}">Truyện</a></li>
                <li><a href="{{ url('/truyen') }}">Thêm truyện</a></li>
                <li><a href="{{ url('/lietketruyen') }}">Liệt kê truyện</a></li>
                <li><a href="{{ url('/decutruyen') }}">Truyện đề cử</a></li>
                <li><a href="{{ url('/capnhattinhtrang') }}">Cập nhật tình trạng</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
            <a href="{{ url('/chap') }}">
                <i class='bx bx-show'></i>
                <span class="link_name">Chap</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
            </div>
            <ul class="sub-menu">
            <li><a class="link_name" href="{{ url('/chap') }}">Chap</a></li>
            <li><a href="{{ url('/chap') }}">Thêm chap</a></li>
            <li><a href="{{ url('/lietkechap') }}">Liệt kê chap</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ url('/binhluan') }}">
                <i class='bx bx-comment-detail'></i>
                <span class="link_name">Bình luận</span>
            </a>
            <ul class="sub-menu blank">
            <li><a class="link_name" href="{{ url('/binhluan') }}">Bình luận</a></li>
            </ul>
        </li>
        <li>
        <div class="profile-details">
        <div class="profile-content">
            @if (Auth::user()->image)
            <img src="{{asset('/uploads/hoso/'.Auth::user()->image)}}" alt="profileImg">
            @else
            <img src="https://res.cloudinary.com/v-network/image/upload/v1656476218/profile_f2bp1t.png" alt="profileImg">
            @endif
        </div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
        <div class="name-job">
            <div class="profile_name">Đăng xuất</div>
        </div>
        <i class='bx bx-log-out' ></i>
        </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
        </form>
    </li>
    </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    @yield('content')
    
    
    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e)=>{
        let arrowParent = e.target.parentElement.parentElement;
        arrowParent.classList.toggle("showMenu");
        });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        sidebarBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("close");
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                scrollY: '70vh',
                scrollCollapse: true,
                paging: false,
            });
        });
    </script>
    <script>
        function ChangeToSlug()
        {

            var slug;
         
            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                //Xóa các ký tự đặt biệt
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '-');
                //Đổi khoảng trắng thành ký tự gạch ngang
                slug = slug.replace(/ /gi, "-");
                //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
                //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                //Xóa các ký tự gạch ngang ở đầu và cuối
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }
    </script>
    </body>
</html>
