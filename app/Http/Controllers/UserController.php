<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Auth;
use App\Models\User;

class UserController extends Controller
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang người dùng');
        }

        $list = User::all();
        return view('nguoidung.index', compact('list'));
    }

    public function phanquyennguoidung(Request $request){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang người dùng');
        }

        $data = array();
        $id = $request->id;
        $data['permission'] = $request->permission;
        DB::table('users')->where('id', $id)->update($data);
    }

    public function motaikhoang(Request $request){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang người dùng');
        }

        $data = array();
        $id = $request->id;
        $data['lock_account'] = 0;
        DB::table('users')->where('id', $id)->update($data);
    }

    public function khoataikhoang(Request $request){
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
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền truy cập vào trang người dùng');
        }

        $data = array();
        $id = $request->id;
        $data['lock_account'] = 1;
        DB::table('users')->where('id', $id)->update($data);
    }
}
