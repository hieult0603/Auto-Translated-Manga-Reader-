<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Auth;

class TheloaiController extends Controller
{
    public function index(){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang thể loại');
        }

        $list = DB::table('theloai')->get();
        return view('theloai.index', compact('list'));
    }

    public function them(Request $request){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang thể loại');
        }

        $data = array();
        $data['tentheloai'] = $request->ten;
        $data['duongdantheloai'] = $request->duongdan;
        DB::table('theloai')->insert($data);
        return Redirect::to('/theloai')->with('success', 'Thêm thể loại thành công');
    }

    public function sua(Request $request, $id){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang thể loại');
        }

        $list = DB::table('theloai')->get();
        $data = DB::table('theloai')->where('matheloai', $id)->get();
        return view('theloai.capnhat', compact('list','data'));
    }

    public function capnhat(Request $request, $id){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang thể loại');
        }

        $data = array();
        $data['tentheloai'] = $request->ten;
        $data['duongdantheloai'] = $request->duongdan;
        DB::table('theloai')->where('matheloai', $id)->update($data);
        return Redirect::to('/theloai')->with('success', 'Cập nhật thể loại thành công');
    }

    public function xoa($id){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang thể loại');
        }
        
        DB::table('theloai')->where('matheloai', $id)->delete();
        return Redirect::to('/theloai')->with('success', 'Xóa thể loại thành công');
    }
}
