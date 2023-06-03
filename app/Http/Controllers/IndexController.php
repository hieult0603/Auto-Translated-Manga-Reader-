<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index(){
        if (Auth::id()) {
            $lock_account = Auth::user()->lock_account;
            if ($lock_account == 1) {
                return view('khoataikhoang');
            }
        }
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        $truyen_hot = DB::table('truyen')->where('truyenhot', 1)->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->take(10)->get();
        $truyen = DB::table('truyen')->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->take(400)->paginate(40);
        foreach($truyen_hot as $key => $value3){
            $chap_hot[$key] = DB::table('chap')->where('matruyen', $value3->matruyen)->orderBy('sochap', 'desc')->first();
        }
        $chap = DB::table('chap')->orderBy('sochap', 'desc')->get();
        $binhluan = DB::table('binhluan')->join('users', 'users.id','=','binhluan.id')->join('truyen' ,'truyen.matruyen','=','binhluan.matruyen')->where('anbinhluan', 0)->orderBy('ngaybinhluan','desc')->take(15)->get();
        $traloibinhluan = DB::table('traloi')->where('antraloi', 0)->get();
        if(Auth::id()){
            $truyen_theodoi = DB::table('theodoi')->where('id', Auth::user()->id)->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->where('id', Auth::user()->id)->orderBy('ngaydoctruyen', 'desc')->get();
            
            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        } else {
            $truyen_theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->orderBy('ngaydoctruyen', 'desc')->get();
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        $truyen_tat = DB::table('truyen')->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->get();
        foreach($truyen_tat as $key => $truyen_tats){
            $chapmoi[$key] = DB::table('chap')->where('matruyen', $truyen_tats->matruyen)->orderBy('sochap', 'desc')->first();
        }
        $time = Carbon::yesterday('Asia/Ho_Chi_Minh');
        $user = DB::table('users')->get();
        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
        if ($checktopngay) {
            $topngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->take(9)->get();
        } else {
            $topngay = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
        if ($checktopthang) {
            $topthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->take(9)->get();
        } else {
            $topthang = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $topall = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(9)->get();
        foreach($topngay as $key => $topngays){
            $newChapForTopDay[$key] = DB::table('chap')->where('matruyen', $topngays->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topthang as $key => $topthangs){
            $newChapForTopMonth[$key] = DB::table('chap')->where('matruyen', $topthangs->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topall as $key => $topalls){
            $newChapForTopAll[$key] = DB::table('chap')->where('matruyen', $topalls->matruyen)->orderBy('sochap', 'desc')->first();
        }
        return view('index', compact('theloai','truyen','truyen_hot','chap_hot','chap','binhluan','traloibinhluan','truyen_theodoi','chapmoi','truyen_tat','truyen_lichsu','user','topngay','topthang','topall','newChapForTopDay','newChapForTopMonth','newChapForTopAll','checktopngay','checktopthang','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function truyen_tranh($slug){
        if (Auth::id()) {
            $lock_account = Auth::user()->lock_account;
            if ($lock_account == 1) {
                return view('khoataikhoang');
            }
        }
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        $truyen = DB::table('truyen')->where('duongdantruyen', $slug)->where('hienthi', 1)->get();
        $truyenn = DB::table('truyen')->where('duongdantruyen', $slug)->join('truyen_theloai', 'truyen.matruyen','=','truyen_theloai.matruyen')->where('hienthi', 1)->select('matheloai')->get();
        $truyen_theloai = DB::table('truyen_theloai')->join('theloai', 'theloai.matheloai','=','truyen_theloai.matheloai')->get();
        $chap = DB::table('chap')->orderBy('sochap', 'desc')->get();
        if (Auth::id()) {
            $theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->where('duongdantruyen', $slug)->where('id', Auth::user()->id)->first();
        } else {
            $theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->where('duongdantruyen', $slug)->first();
        }
        $chap_dau = DB::table('truyen')->where('duongdantruyen', $slug)->where('hienthi', 1)->join('chap', 'chap.matruyen','=','truyen.matruyen')->orderBy('sochap', 'asc')->first();
        $chap_cuoi = DB::table('truyen')->where('duongdantruyen', $slug)->where('hienthi', 1)->join('chap', 'chap.matruyen','=','truyen.matruyen')->orderBy('sochap', 'desc')->first();
        $binhluan = DB::table('binhluan')->join('users', 'users.id','=','binhluan.id')->join('truyen' ,'truyen.matruyen','=','binhluan.matruyen')->where('anbinhluan', 0)->orderBy('ngaybinhluan','desc')->paginate(20);
        $traloibinhluan = DB::table('traloi')->where('antraloi', 0)->get();
        foreach ($truyenn as $key => $truyenns){
            $truyenlienquan = DB::table('truyen_theloai')->join('truyen', 'truyen.matruyen','=','truyen_theloai.matruyen')->whereNotIn('duongdantruyen', [$slug])->select('truyen.matruyen','tentruyen','hinhnen','tentienganh','tacgia','hienthi','duongdantruyen','luotxem','luottheodoi','luotbinhluan')->orderBy(DB::raw('RAND()'))->distinct()->take(10)->get();
        }
        if(Auth::id()){
            $truyen_theodoi = DB::table('theodoi')->where('id', Auth::user()->id)->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->where('id', Auth::user()->id)->orderBy('ngaydoctruyen', 'desc')->get();

            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        }else{
            $truyen_theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->orderBy('ngaydoctruyen', 'desc')->get();
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        $truyen_tat = DB::table('truyen')->where('hienthi', 1)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        foreach($truyen_tat as $key => $truyen_tats){
            $chapmoi[$key] = DB::table('chap')->where('matruyen', $truyen_tats->matruyen)->orderBy('sochap', 'desc')->first();
        }
        $time = Carbon::yesterday('Asia/Ho_Chi_Minh');
        $user = DB::table('users')->get();
        $titletruyen = DB::table('truyen')->where('duongdantruyen', $slug)->first();
        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
        if ($checktopngay) {
            $topngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->take(9)->get();
        } else {
            $topngay = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
        if ($checktopthang) {
            $topthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->take(9)->get();
        } else {
            $topthang = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $topall = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(9)->get();
        foreach($topngay as $key => $topngays){
            $newChapForTopDay[$key] = DB::table('chap')->where('matruyen', $topngays->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topthang as $key => $topthangs){
            $newChapForTopMonth[$key] = DB::table('chap')->where('matruyen', $topthangs->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topall as $key => $topalls){
            $newChapForTopAll[$key] = DB::table('chap')->where('matruyen', $topalls->matruyen)->orderBy('sochap', 'desc')->first();
        }
        return view('truyentranh', compact('theloai','truyen','chap','truyen_theloai','chap_dau','chap_cuoi','binhluan','theodoi','traloibinhluan','truyenlienquan','truyen_theodoi','chapmoi','truyen_tat','truyen_lichsu','user','titletruyen','topngay','topthang','topall','newChapForTopDay','newChapForTopMonth','newChapForTopAll','checktopngay','checktopthang','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function xemtruyentranh($slug, $tap){
        if (Auth::id()) {
            $lock_account = Auth::user()->lock_account;
            if ($lock_account == 1) {
                return view('khoataikhoang');
            }
        }
        $data = array();
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        $chap = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->where('duongdantruyen', $slug)->where('sochap', $tap)->get();
        $chaps = DB::table('chap')->orderBy('sochap', 'desc')->get();
        $danhsachchap = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->where('duongdantruyen', $slug)->get();
        $chaptruoc = DB::table('truyen')->join('chap', 'chap.matruyen','=','truyen.matruyen')->where('duongdantruyen', $slug)->where('sochap', $tap-1)->first();
        $chapsau = DB::table('truyen')->join('chap', 'chap.matruyen','=','truyen.matruyen')->where('duongdantruyen', $slug)->where('sochap', $tap+1)->first();
        $anhchap = DB::table('anhchap')->orderBy('maanhchap', 'asc')->get();
        if (Auth::id()) {
            $theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->where('duongdantruyen', $slug)->where('id', Auth::user()->id)->first();
            if($theodoi){
                $data['sochap'] = $tap;
                DB::table('theodoi')->where('matruyen', $theodoi->matruyen)->where('id', Auth::user()->id)->update($data);
            }
            $lichsu = DB::table('lichsu')->join('truyen', 'truyen.matruyen','=','lichsu.matruyen')->where('duongdantruyen', $slug)->where('id', Auth::user()->id)->first();
            if($lichsu){
                $data['sochap'] = $tap;
                $data['ngaydoctruyen'] = Carbon::now('Asia/Ho_Chi_Minh');
                DB::table('lichsu')->where('matruyen', $lichsu->matruyen)->where('id', Auth::user()->id)->update($data);
            }else{
                $truyen = DB::table('truyen')->where('duongdantruyen', $slug)->first();
                $data['sochap'] = $tap;
                $data['matruyen'] = $truyen->matruyen;
                $data['id'] = Auth::user()->id;
                $data['ngaydoctruyen'] = Carbon::now('Asia/Ho_Chi_Minh');
                DB::table('lichsu')->insert($data);
            }

            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        } else {
            $theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->where('duongdantruyen', $slug)->first();
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        $truyenss = DB::table('truyen')->where('duongdantruyen', $slug)->where('sochap', $tap)->join('chap', 'chap.matruyen','=','truyen.matruyen')->first();
        $data2['luotxem'] = $truyenss->luotxem+1;
        DB::table('truyen')->where('duongdantruyen', $slug)->update($data2);
        $data3['luotxemchap'] = $truyenss->luotxemchap+1;
        DB::table('chap')->where('machap', $truyenss->machap)->update($data3);
        $binhluan = DB::table('binhluan')->join('users', 'users.id','=','binhluan.id')->join('truyen' ,'truyen.matruyen','=','binhluan.matruyen')->where('anbinhluan', 0)->orderBy('ngaybinhluan','desc')->paginate(20);
        $traloibinhluan = DB::table('traloi')->where('antraloi', 0)->get();
        $user = DB::table('users')->get();
        $titletruyen = DB::table('truyen')->join('chap', 'chap.matruyen','=','truyen.matruyen')->where('duongdantruyen', $slug)->where('sochap', $tap)->first();
        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m');
        $checkTimeDay = DB::table('viewngay')->where('matruyen', $truyenss->matruyen)->where('ngayxemtruyen', $timeForTopDay)->first();
        $checkTimeMonth = DB::table('viewthang')->where('matruyen', $truyenss->matruyen)->where('thangxemtruyen', $timeForTopMonth)->first();
        if ($checkTimeDay) {
            $data4['luotxemngay'] = $checkTimeDay->luotxemngay+1;
            DB::table('viewngay')->where('matruyen', $truyenss->matruyen)->where('ngayxemtruyen', $timeForTopDay)->update($data4);
        } else {
            $data4['matruyen'] = $truyenss->matruyen;
            $data4['ngayxemtruyen'] = $timeForTopDay;
            $data4['luotxemngay'] = 1;
            DB::table('viewngay')->insert($data4);
        }
        if ($checkTimeMonth) {
            $data5['luotxemthang'] = $checkTimeMonth->luotxemthang+1;
            DB::table('viewthang')->where('matruyen', $truyenss->matruyen)->where('thangxemtruyen', $timeForTopMonth)->update($data5);
        } else {
            $data5['matruyen'] = $truyenss->matruyen;
            $data5['thangxemtruyen'] = $timeForTopMonth;
            $data5['luotxemthang'] = 1;
            DB::table('viewthang')->insert($data5);
        }
        return view('xemtruyentranh', compact('theloai','chap','anhchap','danhsachchap','chaptruoc','chapsau','theodoi','binhluan','traloibinhluan','chaps','user','titletruyen','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function theodoitruyen($matruyen, $id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $data = array();
        $data['id'] = $id;
        $data['matruyen'] = $matruyen;
        // dd($data);
        DB::table('theodoi')->insert($data);
        $truyen = DB::table('truyen')->where('matruyen', $matruyen)->first();
        $data2['luottheodoi'] = $truyen->luottheodoi+1;
        DB::table('truyen')->where('matruyen', $id)->update($data2);
        return redirect()->back();
    }

    public function botheodoitruyen($matruyen, $id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        // dd($data);
        DB::table('theodoi')->where('id', $id)->where('matruyen', $matruyen)->delete();
        $truyen = DB::table('truyen')->where('matruyen', $matruyen)->first();
        $data2['luottheodoi'] = $truyen->luottheodoi-1;
        DB::table('truyen')->where('matruyen', $id)->update($data2);
        return redirect()->back();
    }

    public function thembinhluantruyen(Request $request, $matruyen, $id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $data = array();
        $data['id'] = $id;
        $data['matruyen'] = $matruyen;
        $data['noidungbinhluan'] = $request->binhluan;
        $data['ngaybinhluan'] = Carbon::now('Asia/Ho_Chi_Minh');
        // dd($data);
        DB::table('binhluan')->insert($data);
        $truyen = DB::table('truyen')->where('matruyen', $matruyen)->first();
        $data2['luotbinhluan'] = $truyen->luotbinhluan+1;
        DB::table('truyen')->where('matruyen', $matruyen)->update($data2);
        return Redirect::to('/truyen-tranh/'.$truyen->duongdantruyen.'#gotocomments');
    }

    public function thembinhluanchap(Request $request, $matruyen, $machap, $id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $data = array();
        $data['id'] = $id;
        $data['matruyen'] = $matruyen;
        $data['machap'] = $machap;
        $data['noidungbinhluan'] = $request->binhluan;
        $data['ngaybinhluan'] = Carbon::now('Asia/Ho_Chi_Minh');
        // dd($data);
        DB::table('binhluan')->insert($data);
        $truyen = DB::table('truyen')->where('matruyen', $matruyen)->first();
        $data2['luotbinhluan'] = $truyen->luotbinhluan+1;
        DB::table('truyen')->where('matruyen', $matruyen)->update($data2);
        $chap = DB::table('chap')->where('machap', $machap)->first();
        return Redirect::to('/truyen-tranh/'.$truyen->duongdantruyen.'/'.$chap->sochap.'#gotocomments');
    }

    public function traloibinhluantruyen(Request $request, $id, $mabinhluan, $uid){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $data = array();
        $data['uid_traloi'] = $uid;
        $data['id'] = $id;
        $data['mabinhluan'] = $mabinhluan;
        $data['noidungtraloi'] = $request->binhluan;
        $data['ngaytraloi'] = Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('traloi')->insert($data);
        $data3['id'] = $id;
        $traloimoi = DB::table('traloi')->orderBy('matraloi', 'desc')->first();
        $data3['matraloi'] = $traloimoi->matraloi;
        DB::table('thongbaobinhluan')->insert($data3);
        $truyen = DB::table('truyen')->join('binhluan', 'binhluan.matruyen','=','truyen.matruyen')->where('mabinhluan', $mabinhluan)->first();
        $data2['luotbinhluan'] = $truyen->luotbinhluan+1;
        DB::table('truyen')->where('matruyen', $id)->update($data2);
        return Redirect::to('/truyen-tranh/'.$truyen->duongdantruyen.'#gotocomments');
    }

    public function traloibinhluanchap(Request $request, $id, $mabinhluan, $tap, $uid){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $data = array();
        $data['uid_traloi'] = $uid;
        $data['id'] = $id;
        $data['mabinhluan'] = $mabinhluan;
        $data['noidungtraloi'] = $request->binhluan;
        $data['ngaytraloi'] = Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('traloi')->insert($data);
        $data3['id'] = $id;
        $traloimoi = DB::table('traloi')->orderBy('matraloi', 'desc')->first();
        $data3['matraloi'] = $traloimoi->matraloi;
        DB::table('thongbaobinhluan')->insert($data3);
        $truyen = DB::table('truyen')->join('binhluan', 'binhluan.matruyen','=','truyen.matruyen')->where('mabinhluan', $mabinhluan)->first();
        $data2['luotbinhluan'] = $truyen->luotbinhluan+1;
        DB::table('truyen')->where('matruyen', $id)->update($data2);
        return Redirect::to('/truyen-tranh/'.$truyen->duongdantruyen.'/'.$tap.'#gotocomments');
    }

    public function theo_doi($id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        $theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->where('id', $id)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        $chap = DB::table('chap')->orderBy('sochap', 'desc')->get();
        $truyen_lichsu = DB::table('lichsu')->where('id', Auth::user()->id)->orderBy('ngaydoctruyen', 'desc')->get();
        $truyen_tat = DB::table('truyen')->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        foreach($truyen_tat as $key => $truyen_tats){
            $chapmoi[$key] = DB::table('chap')->where('matruyen', $truyen_tats->matruyen)->orderBy('sochap', 'desc')->first();
        }
        $time = Carbon::yesterday('Asia/Ho_Chi_Minh');
        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
        if ($checktopngay) {
            $topngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->take(9)->get();
        } else {
            $topngay = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
        if ($checktopthang) {
            $topthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->take(9)->get();
        } else {
            $topthang = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $topall = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(9)->get();
        foreach($topngay as $key => $topngays){
            $newChapForTopDay[$key] = DB::table('chap')->where('matruyen', $topngays->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topthang as $key => $topthangs){
            $newChapForTopMonth[$key] = DB::table('chap')->where('matruyen', $topthangs->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topall as $key => $topalls){
            $newChapForTopAll[$key] = DB::table('chap')->where('matruyen', $topalls->matruyen)->orderBy('sochap', 'desc')->first();
        }
        if(Auth::id()) {
            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        }else{
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        return view('theodoi', compact('theloai','theodoi','chap','truyen_lichsu','truyen_tat','chapmoi','topngay','topthang','topall','newChapForTopDay','newChapForTopMonth','newChapForTopAll','checktopngay','checktopthang','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function lich_su($id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        $lichsu = DB::table('lichsu')->join('truyen', 'truyen.matruyen','=','lichsu.matruyen')->where('id', $id)->orderBy('ngaydoctruyen', 'desc')->paginate(40);
        $chap = DB::table('chap')->orderBy('sochap', 'desc')->get();
        $truyen_theodoi = DB::table('theodoi')->where('id', Auth::user()->id)->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
        $truyen_tat = DB::table('truyen')->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        foreach($truyen_tat as $key => $truyen_tats){
            $chapmoi[$key] = DB::table('chap')->where('matruyen', $truyen_tats->matruyen)->orderBy('sochap', 'desc')->first();
        }
        $time = Carbon::yesterday('Asia/Ho_Chi_Minh');
        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
        if ($checktopngay) {
            $topngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->take(9)->get();
        } else {
            $topngay = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
        if ($checktopthang) {
            $topthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->take(9)->get();
        } else {
            $topthang = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $topall = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(9)->get();
        foreach($topngay as $key => $topngays){
            $newChapForTopDay[$key] = DB::table('chap')->where('matruyen', $topngays->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topthang as $key => $topthangs){
            $newChapForTopMonth[$key] = DB::table('chap')->where('matruyen', $topthangs->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topall as $key => $topalls){
            $newChapForTopAll[$key] = DB::table('chap')->where('matruyen', $topalls->matruyen)->orderBy('sochap', 'desc')->first();
        }
        if(Auth::id()) {
            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        }else{
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        return view('lichsu', compact('theloai','truyen_tat','lichsu','chap','chapmoi','truyen_theodoi','topngay','topthang','topall','newChapForTopDay','newChapForTopMonth','newChapForTopAll','checktopngay','checktopthang','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function xoalichsu($id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        DB::table('lichsu')->where('matruyen', $id)->where('id', Auth::user()->id)->delete();
        return Redirect::to('/lich-su/'.Auth::user()->id);
    }

    public function goto_login(){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
    }

    public function the_loai($slug){
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        $tentheloai = DB::table('theloai')->where('duongdantheloai', $slug)->first();
        if(Auth::id()){
            $truyen_theodoi = DB::table('theodoi')->where('id', Auth::user()->id)->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->where('id', Auth::user()->id)->orderBy('ngaydoctruyen', 'desc')->get();

            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        }else{
            $truyen_theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->orderBy('ngaydoctruyen', 'desc')->get();
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        $truyen_tat = DB::table('truyen')->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        foreach($truyen_tat as $key => $truyen_tats){
            $chapmoi[$key] = DB::table('chap')->where('matruyen', $truyen_tats->matruyen)->orderBy('sochap', 'desc')->first();
        }
        $time = Carbon::yesterday('Asia/Ho_Chi_Minh');
        $truyen_theloai = DB::table('truyen_theloai')->join('truyen', 'truyen.matruyen','=','truyen_theloai.matruyen')->join('theloai', 'theloai.matheloai','=','truyen_theloai.matheloai')->where('duongdantheloai', $slug)->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        $chap = DB::table('chap')->orderBy('sochap', 'desc')->get();
        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
        if ($checktopngay) {
            $topngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->take(9)->get();
        } else {
            $topngay = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
        if ($checktopthang) {
            $topthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->take(9)->get();
        } else {
            $topthang = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $topall = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(9)->get();
        foreach($topngay as $key => $topngays){
            $newChapForTopDay[$key] = DB::table('chap')->where('matruyen', $topngays->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topthang as $key => $topthangs){
            $newChapForTopMonth[$key] = DB::table('chap')->where('matruyen', $topthangs->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topall as $key => $topalls){
            $newChapForTopAll[$key] = DB::table('chap')->where('matruyen', $topalls->matruyen)->orderBy('sochap', 'desc')->first();
        }
        return view('theloai', compact('theloai','tentheloai','truyen_theodoi','truyen_lichsu','chapmoi','truyen_tat','chap','truyen_theloai','topngay','topthang','topall','newChapForTopDay','newChapForTopMonth','newChapForTopAll','checktopngay','checktopthang','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function truyen_hot(){
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        if(Auth::id()){
            $truyen_theodoi = DB::table('theodoi')->where('id', Auth::user()->id)->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->where('id', Auth::user()->id)->orderBy('ngaydoctruyen', 'desc')->get();

            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        }else{
            $truyen_theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
            $truyen_lichsu = DB::table('lichsu')->orderBy('ngaydoctruyen', 'desc')->get();
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        $truyen_tat = DB::table('truyen')->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        foreach($truyen_tat as $key => $truyen_tats){
            $chapmoi[$key] = DB::table('chap')->where('matruyen', $truyen_tats->matruyen)->orderBy('sochap', 'desc')->first();
        }
        $time = Carbon::yesterday('Asia/Ho_Chi_Minh');
        $truyen_hot = DB::table('truyen')->where('truyenhot', 1)->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->paginate(40);
        $chap = DB::table('chap')->orderBy('sochap', 'desc')->get();
        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
        if ($checktopngay) {
            $topngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->take(9)->get();
        } else {
            $topngay = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
        if ($checktopthang) {
            $topthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->take(9)->get();
        } else {
            $topthang = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
        }
        $topall = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(9)->get();
        foreach($topngay as $key => $topngays){
            $newChapForTopDay[$key] = DB::table('chap')->where('matruyen', $topngays->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topthang as $key => $topthangs){
            $newChapForTopMonth[$key] = DB::table('chap')->where('matruyen', $topthangs->matruyen)->orderBy('sochap', 'desc')->first();
        }
        foreach($topall as $key => $topalls){
            $newChapForTopAll[$key] = DB::table('chap')->where('matruyen', $topalls->matruyen)->orderBy('sochap', 'desc')->first();
        }
        return view('truyenhot', compact('theloai','truyen_theodoi','truyen_lichsu','chapmoi','truyen_tat','chap','truyen_hot','topngay','topthang','topall','newChapForTopDay','newChapForTopMonth','newChapForTopAll','checktopngay','checktopthang','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function tim_kiem(Request $request){
        if (isset($_GET['search'])) {
            $search = $_GET['search'];

            $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
            if(Auth::id()){
                $truyen_theodoi = DB::table('theodoi')->where('id', Auth::user()->id)->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
                $truyen_lichsu = DB::table('lichsu')->where('id', Auth::user()->id)->orderBy('ngaydoctruyen', 'desc')->get();

                $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
                if ($checkNotify) {
                    $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                    $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
                } else {
                    $count_notification = 0;
                    $thongbaobinhluan = 0;
                }
            }else{
                $truyen_theodoi = DB::table('theodoi')->join('truyen', 'truyen.matruyen','=','theodoi.matruyen')->orderBy('ngaycapnhat', 'desc')->get();
                $truyen_lichsu = DB::table('lichsu')->orderBy('ngaydoctruyen', 'desc')->get();
                $checkNotify = false;
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
            $truyen_tat = DB::table('truyen')->where('hienthi', 1)->where('ngaycapnhat','<>',null)->orderBy('ngaycapnhat', 'desc')->paginate(40);
            foreach($truyen_tat as $key => $truyen_tats){
                $chapmoi[$key] = DB::table('chap')->where('matruyen', $truyen_tats->matruyen)->orderBy('sochap', 'desc')->first();
            }
            $time = Carbon::yesterday('Asia/Ho_Chi_Minh');
            $truyen_search = DB::table('truyen')->where('tentruyen', 'LIKE','%'.$search.'%')->where('ngaycapnhat','<>',null)->where('hienthi', 1)->orWhere('tentienganh', 'LIKE','%'.$search.'%')->where('hienthi', 1)->orderBy('ngaycapnhat', 'desc')->paginate(40);
            $chap = DB::table('chap')->orderBy('sochap', 'desc')->get();
            $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
            $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
            $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
            if ($checktopngay) {
                $topngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->take(9)->get();
            } else {
                $topngay = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
            }
            $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
            if ($checktopthang) {
                $topthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->take(9)->get();
            } else {
                $topthang = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(1)->get();
            }
            $topall = DB::table('truyen')->where('ngaycapnhat','<>',null)->orderBy('luotxem', 'desc')->take(9)->get();
            foreach($topngay as $key => $topngays){
                $newChapForTopDay[$key] = DB::table('chap')->where('matruyen', $topngays->matruyen)->orderBy('sochap', 'desc')->first();
            }
            foreach($topthang as $key => $topthangs){
                $newChapForTopMonth[$key] = DB::table('chap')->where('matruyen', $topthangs->matruyen)->orderBy('sochap', 'desc')->first();
            }
            foreach($topall as $key => $topalls){
                $newChapForTopAll[$key] = DB::table('chap')->where('matruyen', $topalls->matruyen)->orderBy('sochap', 'desc')->first();
            }
            return view('timkiem', compact('theloai','truyen_theodoi','truyen_lichsu','chapmoi','truyen_tat','chap','truyen_search','search','topngay','topthang','topall','newChapForTopDay','newChapForTopMonth','newChapForTopAll','checktopngay','checktopthang','checkNotify','count_notification','thongbaobinhluan'));
        }else{
            return Redirect::to('/');
        }
    }

    public function checkallnotification(Request $request) {
        $id = $request->id;
        $data['dadoc'] = 1;
        DB::table('thongbaobinhluan')->where('id', $id)->update($data);
    }

    public function anbinhluan(Request $request) {
        $id = $request->id;
        $data['anbinhluan'] = 1;
        DB::table('binhluan')->where('mabinhluan', $id)->update($data);
    }

    public function antraloi(Request $request) {
        $id = $request->id;
        $data['antraloi'] = 1;
        DB::table('traloi')->where('matraloi', $id)->update($data);
    }
}
