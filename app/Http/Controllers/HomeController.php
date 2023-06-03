<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function home(){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $permission = Auth::user()->permission;
        $lock_account = Auth::user()->lock_account;
        if ($lock_account == 1) {
            return view('khoataikhoang');
        }
        if ($permission == 0) {
            return Redirect::to('/');
        }
        if ($permission == 2) {
            return Redirect::to('/truyen');
        }

        $timeForTopDay = Carbon::now('Asia/Ho_Chi_Minh')->subDay(1)->format('Y-m-d');
        $timeForTopMonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth(1)->format('Y-m');
        $checktopngay = DB::table('viewngay')->join('truyen', 'truyen.matruyen','=','viewngay.matruyen')->where('ngaycapnhat','<>',null)->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->exists();
        if ($checktopngay) {
            $topngay = DB::table('viewngay')->where('ngayxemtruyen','>',$timeForTopDay)->orderBy('luotxemngay', 'desc')->get();
            $tongxemngay = 0;
            foreach ($topngay as $key => $topngays) {
                $tongxemngay = $tongxemngay + $topngays->luotxemngay;
            }
        } else {
            $tongxemngay = 0;
        }
        $checktopthang = DB::table('viewthang')->join('truyen', 'truyen.matruyen','=','viewthang.matruyen')->where('ngaycapnhat','<>',null)->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->exists();
        if ($checktopthang) {
            $topthang = DB::table('viewthang')->where('thangxemtruyen','>',$timeForTopMonth)->orderBy('luotxemthang', 'desc')->get();
            $tongxemthang = 0;
            foreach ($topthang as $key => $topthangs) {
                $tongxemthang = $tongxemthang + $topthangs->luotxemthang;
            }
        } else {
            $tongxemthang = 0;
        }
        $year = Carbon::now()->format('Y');
        $checkThang1 = DB::table('viewthang')->where('thangxemtruyen',$year.'-01')->exists();
        if ($checkThang1) {
            $thang1 = DB::table('viewthang')->where('thangxemtruyen',$year.'-01')->get();
            $tongthang1 = 0;
            foreach ($thang1 as $key => $thang1s) {
                $tongthang1 = $tongthang1 + $thang1s->luotxemthang;
            }
        } else {
            $tongthang1 = 0;
        }
        $checkThang2 = DB::table('viewthang')->where('thangxemtruyen',$year.'-02')->exists();
        if ($checkThang2) {
            $thang2 = DB::table('viewthang')->where('thangxemtruyen',$year.'-02')->get();
            $tongthang2 = 0;
            foreach ($thang2 as $key => $thang2s) {
                $tongthang2 = $tongthang2 + $thang2s->luotxemthang;
            }
        } else {
            $tongthang2 = 0;
        }
        $checkThang3 = DB::table('viewthang')->where('thangxemtruyen',$year.'-03')->exists();
        if ($checkThang3) {
            $thang3 = DB::table('viewthang')->where('thangxemtruyen',$year.'-03')->get();
            $tongthang3 = 0;
            foreach ($thang3 as $key => $thang3s) {
                $tongthang3 = $tongthang3 + $thang3s->luotxemthang;
            }
        } else {
            $tongthang3 = 0;
        }
        $checkThang4 = DB::table('viewthang')->where('thangxemtruyen',$year.'-04')->exists();
        if ($checkThang4) {
            $thang4 = DB::table('viewthang')->where('thangxemtruyen',$year.'-04')->get();
            $tongthang4 = 0;
            foreach ($thang4 as $key => $thang4s) {
                $tongthang4 = $tongthang4 + $thang4s->luotxemthang;
            }
        } else {
            $tongthang4 = 0;
        }
        $checkThang5 = DB::table('viewthang')->where('thangxemtruyen',$year.'-05')->exists();
        if ($checkThang5) {
            $thang5 = DB::table('viewthang')->where('thangxemtruyen',$year.'-05')->get();
            $tongthang5 = 0;
            foreach ($thang5 as $key => $thang5s) {
                $tongthang5 = $tongthang5 + $thang5s->luotxemthang;
            }
        } else {
            $tongthang5 = 0;
        }
        $checkThang6 = DB::table('viewthang')->where('thangxemtruyen',$year.'-06')->exists();
        if ($checkThang6) {
            $thang6 = DB::table('viewthang')->where('thangxemtruyen',$year.'-06')->get();
            $tongthang6 = 0;
            foreach ($thang6 as $key => $thang6s) {
                $tongthang6 = $tongthang6 + $thang6s->luotxemthang;
            }
        } else {
            $tongthang6 = 0;
        }
        $checkThang7 = DB::table('viewthang')->where('thangxemtruyen',$year.'-07')->exists();
        if ($checkThang7) {
            $thang7 = DB::table('viewthang')->where('thangxemtruyen',$year.'-07')->get();
            $tongthang7 = 0;
            foreach ($thang7 as $key => $thang7s) {
                $tongthang7 = $tongthang7 + $thang7s->luotxemthang;
            }
        } else {
            $tongthang7 = 0;
        }
        $checkThang8 = DB::table('viewthang')->where('thangxemtruyen',$year.'-08')->exists();
        if ($checkThang8) {
            $thang8 = DB::table('viewthang')->where('thangxemtruyen',$year.'-08')->get();
            $tongthang8 = 0;
            foreach ($thang8 as $key => $thang8s) {
                $tongthang8 = $tongthang8 + $thang8s->luotxemthang;
            }
        } else {
            $tongthang8 = 0;
        }
        $checkThang9 = DB::table('viewthang')->where('thangxemtruyen',$year.'-09')->exists();
        if ($checkThang9) {
            $thang9 = DB::table('viewthang')->where('thangxemtruyen',$year.'-09')->get();
            $tongthang9 = 0;
            foreach ($thang9 as $key => $thang9s) {
                $tongthang9 = $tongthang9 + $thang9s->luotxemthang;
            }
        } else {
            $tongthang9 = 0;
        }
        $checkThang10 = DB::table('viewthang')->where('thangxemtruyen',$year.'-10')->exists();
        if ($checkThang10) {
            $thang10 = DB::table('viewthang')->where('thangxemtruyen',$year.'-10')->get();
            $tongthang10 = 0;
            foreach ($thang10 as $key => $thang10s) {
                $tongthang10 = $tongthang10 + $thang10s->luotxemthang;
            }
        } else {
            $tongthang10 = 0;
        }
        $checkThang11 = DB::table('viewthang')->where('thangxemtruyen',$year.'-11')->exists();
        if ($checkThang11) {
            $thang11 = DB::table('viewthang')->where('thangxemtruyen',$year.'-11')->get();
            $tongthang11 = 0;
            foreach ($thang11 as $key => $thang11s) {
                $tongthang11 = $tongthang11 + $thang11s->luotxemthang;
            }
        } else {
            $tongthang11 = 0;
        }
        $checkThang12 = DB::table('viewthang')->where('thangxemtruyen',$year.'-12')->exists();
        if ($checkThang12) {
            $thang12 = DB::table('viewthang')->where('thangxemtruyen',$year.'-12')->get();
            $tongthang12 = 0;
            foreach ($thang12 as $key => $thang12s) {
                $tongthang12 = $tongthang12 + $thang12s->luotxemthang;
            }
        } else {
            $tongthang12 = 0;
        }

        $users = DB::table('users')->count();

        return view('home', compact('tongxemngay','tongxemthang','users','tongthang1','tongthang2','tongthang3','tongthang4','tongthang5','tongthang6','tongthang7','tongthang8','tongthang9','tongthang10','tongthang11','tongthang12'));
    }
}
