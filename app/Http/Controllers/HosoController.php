<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redirect;
use Auth;
use Storage;
use File;

class HosoController extends Controller
{
    public function index($id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        if(Auth::id()){
            $checkNotify = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->exists();
            if ($checkNotify) {
                $count_notification = DB::table('thongbaobinhluan')->where('id', Auth::user()->id)->where('dadoc', 0)->count();
                $thongbaobinhluan = DB::table('thongbaobinhluan')->join('traloi', 'traloi.matraloi', '=', 'thongbaobinhluan.matraloi')->join('users', 'users.id', '=', 'traloi.uid_traloi')->join('binhluan', 'binhluan.mabinhluan', '=', 'traloi.mabinhluan')->join('truyen', 'truyen.matruyen', '=', 'binhluan.matruyen')->where('thongbaobinhluan.id', Auth::user()->id)->orderBy('mathongbaobinhluan', 'desc')->get();
            } else {
                $count_notification = 0;
                $thongbaobinhluan = 0;
            }
        } else {
            $checkNotify = false;
            $count_notification = 0;
            $thongbaobinhluan = 0;
        }
        
        $theloai = DB::table('theloai')->orderBy('tentheloai','asc')->get();
        return view('hoso.index', compact('theloai','checkNotify','count_notification','thongbaobinhluan'));
    }

    public function capnhat(Request $request, $id){
        if (!Auth::id()) {
            return Redirect::to('/login');
        }
        $user = DB::table('users')->where('id', $id)->get();
        $data = array();
        $data['name'] = $request->ten;
        $get_file = $request->file('file');
        foreach($user as $user){
            if($get_file){
                if(isset($user->image)){
                    // $content = collect(Storage::disk('hoso')->listContents('/', false))->where('name','=', $user->image);
                    // foreach($content as $content){
                    //     Storage::disk('hoso')->delete($content['path']);
                    // }
                    unlink('uploads/hoso/'.$user->image);
                    $get_name_file = $get_file->getClientOriginalName();
                    $name_file = current(explode('.',$get_name_file));
                    $new_file = $name_file.'_'.rand(0,9999).'.'.$get_file->getClientOriginalExtension();
                    $fileData = File::get($get_file);
                    // $googleDisk = Storage::disk('hoso')->put($new_file, $fileData);
                    $get_file->move('uploads/hoso/',$new_file);
                    $data['image'] = $new_file;
                }else{
                    $get_name_file = $get_file->getClientOriginalName();
                    $name_file = current(explode('.',$get_name_file));
                    $new_file = $name_file.'_'.rand(0,9999).'.'.$get_file->getClientOriginalExtension();
                    $fileData = File::get($get_file);
                    // $googleDisk = Storage::disk('hoso')->put($new_file, $fileData);
                    $get_file->move('uploads/hoso/',$new_file);
                    $data['image'] = $new_file;
                }
            }
        }
        DB::table('users')->where('id', $id)->update($data);
        return redirect()->to('/hoso/'.$id)->with('success', 'Cập nhật hồ sơ thành công');
    }
}
