<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Auth;

class BinhluanController extends Controller
{
    public function index() {
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang đề cử truyện');
        }

        $binhluan = DB::table('binhluan')->where('anbinhluan', 1)->join('users', 'users.id','=','binhluan.id')->join('truyen', 'truyen.matruyen','=','binhluan.matruyen')->get();
        $traloi = DB::table('traloi')->where('antraloi', 1)->join('binhluan', 'binhluan.mabinhluan','=','traloi.mabinhluan')->join('users', 'users.id','=','traloi.uid_traloi')->join('truyen', 'truyen.matruyen','=','binhluan.matruyen')->get();
        return view('binhluan.index', compact('binhluan','traloi'));
    }

    public function hienbinhluan(Request $request) {
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang đề cử truyện');
        }

        $data['anbinhluan'] = 0;
        $mabinhluan = $request->mabinhluan;
        DB::table('binhluan')->where('mabinhluan', $mabinhluan)->update($data);
    }

    public function hientraloi(Request $request) {
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang đề cử truyện');
        }

        $data['antraloi'] = 0;
        $matraloi = $request->matraloi;
        DB::table('traloi')->where('matraloi', $matraloi)->update($data);
    }
}
