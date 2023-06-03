<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Auth;
use Storage;
use File;
use Carbon\Carbon;

class TruyenController extends Controller
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
            $list = DB::table('truyen')->orderBy('matruyen', 'desc')->get();
        } else {
            $list = DB::table('truyen')->where('nguoidangtruyen', Auth::user()->id)->orderBy('matruyen', 'desc')->get();
        }
        $destinationPath = public_path()."/json/";
        if(!is_dir($destinationPath)){mkdir($destinationPath,0777,true);}
        File::put($destinationPath.'truyen.json',json_encode($list));
        
        $theloai = DB::table('theloai')->orderBy('tentheloai', 'asc')->get();
        $truyen_theloai = DB::table('truyen_theloai')->join('truyen', 'truyen.matruyen','=','truyen_theloai.matruyen')->join('theloai', 'theloai.matheloai','=','truyen_theloai.matheloai')->get();
        return view('truyen.index', compact('list','theloai','truyen_theloai'));
    }

    public function them (Request $request){
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
        $data['tentruyen'] = $request->tentruyen; 
        $data['tentienganh'] = $request->tentienganh; 
        $data['duongdantruyen'] = $request->duongdan; 
        $data['tacgia'] = $request->tentacgia; 
        $data['truyenhot'] = $request->truyenhot; 
        $data['hienthi'] = $request->hienthi; 
        $data['noidungtruyen'] = $request->noidungtruyen; 
        $data['ngaytao'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['nguoidangtruyen'] = Auth::user()->id;
        $get_file = $request->file('file');
        if($get_file){
            $get_name_file = $get_file->getClientOriginalName();
            $name_file = current(explode('.',$get_name_file));
            $new_file = $name_file.'_'.rand(0,9999).'.'.$get_file->getClientOriginalExtension();
            $fileData = File::get($get_file);
            // $googleDisk = Storage::disk('truyen')->put($new_file, $fileData); 
            $get_file->move('uploads/truyen/',$new_file);
            $data['hinhnen'] = $new_file;
        }
        DB::table('truyen')->insert($data);
        $truyen = DB::table('truyen')->orderBy('matruyen', 'DESC')->first();
        $data2['matheloai'] = $request->theloai;
        foreach($data2['matheloai'] as $key => $value){
            $data1 = array();
            $data1['matruyen'] = $truyen->matruyen;
            $data1['matheloai'] = $value;
            DB::table('truyen_theloai')->insert($data1);
        }
        return Redirect::to('/truyen')->with('success', 'Thêm truyện thành công');
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

        $truyen = DB::table('truyen')->where('matruyen', $id)->first();
        if ($truyen->nguoidangtruyen == Auth::user()->id || $permission == 1) {
            if ($permission == 1) {
                $list = DB::table('truyen')->orderBy('matruyen', 'desc')->get();
            } else {
                $list = DB::table('truyen')->where('nguoidangtruyen', Auth::user()->id)->orderBy('matruyen', 'desc')->get();
            }
            $theloai = DB::table('theloai')->orderBy('tentheloai', 'asc')->get();
            $truyen_theloai = DB::table('truyen_theloai')->join('truyen', 'truyen.matruyen','=','truyen_theloai.matruyen')->join('theloai', 'theloai.matheloai','=','truyen_theloai.matheloai')->get();
            $data = DB::table('truyen')->where('matruyen', $id)->get();
            $data2 = DB::table('truyen')->where('truyen.matruyen', $id)->join('truyen_theloai', 'truyen.matruyen','=','truyen_theloai.matruyen')->select('matheloai')->get();
            // dd($data2,$theloai);
            return view('truyen.capnhat', compact('list','theloai','truyen_theloai','data','data2'));
        } else {
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền sửa truyện này');
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
        $data['tentruyen'] = $request->tentruyen; 
        $data['tentienganh'] = $request->tentienganh; 
        $data['duongdantruyen'] = $request->duongdan; 
        $data['tacgia'] = $request->tentacgia; 
        $data['truyenhot'] = $request->truyenhot; 
        $data['hienthi'] = $request->hienthi; 
        $data['noidungtruyen'] = $request->noidungtruyen; 
        $get_file = $request->file('file');
        $truyen = DB::table('truyen')->where('matruyen', $id)->get();
        foreach($truyen as $truyens){
            if($get_file){
                if(isset($truyens->hinhnen)){
                    // $content = collect(Storage::disk('truyen')->listContents('/', false))->where('name','=', $truyens->hinhnen);
                    // foreach($content as $content){
                    //     Storage::disk('truyen')->delete($content['path']);
                    // }
                    unlink('uploads/truyen/'.$truyens->hinhnen);
                    $get_name_file = $get_file->getClientOriginalName();
                    $name_file = current(explode('.',$get_name_file));
                    $new_file = $name_file.'_'.rand(0,9999).'.'.$get_file->getClientOriginalExtension();
                    $fileData = File::get($get_file);
                    // $googleDisk = Storage::disk('truyen')->put($new_file, $fileData);
                    $get_file->move('uploads/truyen/',$new_file);
                    $data['hinhnen'] = $new_file;
                }else{
                    $get_name_file = $get_file->getClientOriginalName();
                    $name_file = current(explode('.',$get_name_file));
                    $new_file = $name_file.'_'.rand(0,9999).'.'.$get_file->getClientOriginalExtension();
                    $fileData = File::get($get_file);
                    // $googleDisk = Storage::disk('truyen')->put($new_file, $fileData);
                    $get_file->move('uploads/truyen/',$new_file);
                    $data['hinhnen'] = $new_file;
                }
            }
        }
        // dd($data);
        DB::table('truyen')->where('matruyen', $id)->update($data);
        DB::table('truyen_theloai')->where('matruyen', $id)->delete(); 
        $data2['matheloai'] = $request->theloai;
        foreach($data2['matheloai'] as $key => $value){
            $data1 = array();
            $data1['matruyen'] = $id;
            $data1['matheloai'] = $value;
            DB::table('truyen_theloai')->insert($data1);
        }
        return Redirect::to('/truyen')->with('success', 'Cập nhật truyện thành công');
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
            $list = DB::table('truyen')->orderBy('matruyen', 'desc')->get();
        } else {
            $list = DB::table('truyen')->where('nguoidangtruyen', Auth::user()->id)->orderBy('matruyen', 'desc')->get();
        }
        $truyen_theloai = DB::table('truyen_theloai')->join('truyen', 'truyen.matruyen','=','truyen_theloai.matruyen')->join('theloai', 'theloai.matheloai','=','truyen_theloai.matheloai')->get();
        return view('truyen.lietke', compact('list','truyen_theloai'));
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

        $truyen = DB::table('truyen')->where('matruyen', $id)->first();
        if ($truyen->nguoidangtruyen == Auth::user()->id || $permission == 1) {
            $truyen = DB::table('truyen')->where('matruyen', $id)->get();
            foreach($truyen as $truyens){
                if(isset($truyens->hinhnen)){
                    // $content = collect(Storage::disk('truyen')->listContents('/', false))->where('name','=', $truyens->hinhnen);
                    // foreach($content as $contents){
                    //     Storage::disk('truyen')->delete($contents['path']);
                    // }
                    unlink('uploads/truyen/'.$truyens->hinhnen);
                }
                $tentruyen = $truyens->tentruyen;
            }
            DB::table('truyen')->where('matruyen', $id)->delete();
            DB::table('truyen_theloai')->where('matruyen', $id)->delete();
            return redirect()->to('/truyen')->with('success', 'Đã xóa truyện '.$tentruyen);
        } else {
            return Redirect::to('/truyen')->with('error', 'Bạn không có quyền xóa truyện này');
        }
    }

    public function decutruyen(){
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

        $list = DB::table('truyen')->get();
        return view('truyen.decutruyen', compact('list'));
    }

    public function themdecutruyen(Request $request){
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

        $matruyen = $request->matruyen;
        $data['truyenhot'] = 1;
        DB::table('truyen')->where('matruyen', $matruyen)->update($data);
    }

    public function bodecutruyen(Request $request){
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

        $matruyen = $request->matruyen;
        $data['truyenhot'] = 0;
        DB::table('truyen')->where('matruyen', $matruyen)->update($data);
    }

    public function capnhattinhtrang(Request $request) {
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
            $list = DB::table('truyen')->orderBy('matruyen', 'desc')->get();
        } else {
            $list = DB::table('truyen')->where('nguoidangtruyen', Auth::user()->id)->orderBy('matruyen', 'desc')->get();
        }
        return view('truyen.capnhattinhtrang', compact('list'));
    }

    public function themtruyenhoanthanh(Request $request){
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

        $matruyen = $request->matruyen;
        $data['tinhtrang'] = 1;
        DB::table('truyen')->where('matruyen', $matruyen)->update($data);
    }

    public function botruyenhoanthanh(Request $request){
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

        $matruyen = $request->matruyen;
        $data['tinhtrang'] = 0;
        DB::table('truyen')->where('matruyen', $matruyen)->update($data);
    }
}
