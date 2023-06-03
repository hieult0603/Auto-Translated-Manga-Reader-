<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Auth;
use Storage;
use File;
use Carbon\Carbon;

class ChapController extends Controller
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

        if ($permission == 1) {
            $list = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->get();
        } else {
            $list = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->where('nguoidangtruyen', Auth::user()->id)->get();
        }
        $truyen = DB::table('truyen')->orderBy('tentruyen', 'asc')->get();
        return view('chap.index', compact('list','truyen'));
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

        $truyen = DB::table('truyen')->where('matruyen', $request->truyen)->first();
        if ($truyen->nguoidangtruyen == Auth::user()->id || $permission == 1) {
            $data = array();
            $data2 = array();
            $data['sochap'] = $request->sochap;
            $data['matruyen'] = $request->truyen;
            $data['ngaytaochap'] = Carbon::now('Asia/Ho_Chi_Minh');
            $get_files = $request->file('file');
            DB::table('chap')->insert($data);
            $data3['ngaycapnhat'] = Carbon::now('Asia/Ho_Chi_Minh');
            DB::table('truyen')->where('matruyen', $request->truyen)->update($data3);
            $new_chap = DB::table('chap')->orderBy('machap', 'desc')->first();
            if ($get_files) {
                foreach ($get_files as $get_file){
                    $get_name_file = $get_file->getClientOriginalName();
                    $name_file = current(explode('.',$get_name_file));
                    $new_file = $name_file.'_'.rand(0,9999).'.'.$get_file->getClientOriginalExtension();
                    $fileData = File::get($get_file);
                    // $googleDisk = Storage::disk('chap')->put($new_file, $fileData); 
                    $get_file->move('uploads/chap/',$new_file);
                    $data2['hinhanh'] = $new_file;
                    $data2['machap'] = $new_chap->machap;
                    DB::table('anhchap')->insert($data2);
                }
            }
            return Redirect::to('/chap')->with('success', 'Thêm tập truyện thành công');
        } else {
            return Redirect::to('/chap')->with('error', 'Bạn không có quyền thêm tập truyện cho truyện này');
        }
    }

    public function sua($id){
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

        $chap = DB::table('chap')->where('machap', $id)->first();
        $truyen = DB::table('truyen')->where('matruyen', $chap->matruyen)->first();
        if ($truyen->nguoidangtruyen == Auth::user()->id || $permission == 1) {
            if ($permission == 1) {
                $list = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->get();
            } else {
                $list = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->where('nguoidangtruyen', Auth::user()->id)->get();
            }
            $truyen = DB::table('truyen')->orderBy('tentruyen', 'asc')->get();
            $data = DB::table('chap')->where('machap', $id)->get();
            $anhchap = DB::table('anhchap')->where('machap',$id)->get();
            return view('chap.capnhat', compact('list','truyen','data','anhchap'));
        } else {
            return Redirect::to('/chap')->with('error', 'Bạn không có quyền sửa tập truyện của truyện này');
        }
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

        $data = array();
        $data2 = array();
        $data['sochap'] = $request->sochap;
        $data['matruyen'] = $request->truyen;
        $get_files = $request->file('file');
        $anhchap = DB::table('anhchap')->where('machap', $id)->get();
        if ($get_files) {
            foreach($anhchap as $anhchaps){
                if(isset($anhchaps->hinhanh)){
                    // $content = collect(Storage::disk('chap')->listContents('/', false))->where('name','=', $anhchaps->hinhanh);
                    // foreach($content as $content){
                    //     Storage::disk('chap')->delete($content['path']);
                    // }
                    unlink('uploads/chap/'.$anhchaps->hinhanh);
                    DB::table('anhchap')->where('machap', $id)->where('hinhanh', $anhchaps->hinhanh)->delete();
                }
            }
            foreach ($get_files as $get_file){
                $get_name_file = $get_file->getClientOriginalName();
                $name_file = current(explode('.',$get_name_file));
                $new_file = $name_file.'_'.rand(0,9999).'.'.$get_file->getClientOriginalExtension();
                $fileData = File::get($get_file);
                // $googleDisk = Storage::disk('chap')->put($new_file, $fileData); 
                $get_file->move('uploads/chap/',$new_file);
                $data2['hinhanh'] = $new_file;
                $data2['machap'] = $id;
                DB::table('anhchap')->insert($data2);
            }
        }
        DB::table('chap')->where('machap', $id)->update($data);
        return Redirect::to('/chap')->with('success', 'Cập nhật tập truyện thành công');
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

        $chap = DB::table('chap')->where('machap', $id)->first();
        $truyen = DB::table('truyen')->where('matruyen', $chap->matruyen)->first();
        if ($truyen->nguoidangtruyen == Auth::user()->id || $permission == 1) {
            $anhchap = DB::table('anhchap')->where('machap', $id)->get();
            foreach($anhchap as $anhchaps){
                if(isset($anhchaps->hinhanh)){
                    // $content = collect(Storage::disk('chap')->listContents('/', false))->where('name','=', $anhchaps->hinhanh);
                    // foreach($content as $contents){
                    //     Storage::disk('chap')->delete($contents['path']);
                    // }
                    unlink('uploads/chap/'.$anhchaps->hinhanh);
                }
            }
            DB::table('chap')->where('machap', $id)->delete();
            DB::table('anhchap')->where('machap', $id)->delete();
            return redirect()->to('/chap')->with('success', 'Xóa tập truyện thành công');
        } else {
            return Redirect::to('/chap')->with('error', 'Bạn không có quyền xóa tập truyện của truyện này');
        }
    }

    public function lietke(){
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

        if ($permission == 1) {
            $list = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->get();
        } else {
            $list = DB::table('chap')->join('truyen', 'truyen.matruyen','=','chap.matruyen')->where('nguoidangtruyen', Auth::user()->id)->get();
        }
        return view('chap.lietke', compact('list'));
    }

    public function xoaanh($id, $name, $maanhchap){
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

        // $content = collect(Storage::disk('chap')->listContents('/', false))->where('name','=', $name);
        // foreach($content as $contents){
        //     Storage::disk('chap')->delete($contents['path']);
        // }
        unlink('uploads/chap/'.$name);
        DB::table('anhchap')->where('machap', $id)->where('maanhchap', $maanhchap)->delete();
        return Redirect::to('/suachap/'.$id)->with('success', 'Đã xóa ảnh'.$name);
    }
}
