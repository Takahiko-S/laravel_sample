<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Picture;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
class AdminController extends Controller
{
    
    //ユーザリスト表示
    public function userList() {
        $user_list = User::all();
        
        return view('admin.user_list',compact('user_list'));
    }
    
    //ユーザー変更
    public function changeUser(Request $request){
        print_r($request->all());
        $user = User::find($request->change_id);
        if($request->change_name != ""){
            $user->name = $request->change_name;
        }
        if($request->change_pass != "" && strlen($request->change_pass) >=8){//strlenは文字列の長さを調べる
            $user->password = Hash::make($request->change_pass);
        }
        $user->save();
        return;
    }
    
    //ユーザー削除
    public function deleteUser(Request $request){
        print_r($request->all());
        $pictures = Picture::where('u_id',$request->delete_id)->get();
        foreach($pictures as $picture){
            //print $picture->file_name;
            //print $picture->thumb_name;
            //画像データ削除
            Storage::delete("main_images/" . $picture->file_name);
            Storage::delete("thumb_images/" . $picture->thumb_name);
        }
        //Pictureテーブルから該当ユーザーのデータの一括削除
        Picture::where('u_id',$request->delete_id)->delete();
        //Userテーブルからユーザを削除
        User::destroy($request->delete_id);
        return;
    }
    //adminユーザリスト表示
    public function adminList() {
        $user_list = Admin::all();
        
        return view('admin.admin_list',compact('user_list'));
    }
    
    public function saveAdmin(Request $request){
        //dd($request->all());
   
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email:strict,dns,spoof', 'max:255', 'unique:'.Admin::class],
        'password' => ['required',  Rules\Password::defaults()],
    ]);
    
    $user = Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    
    event(new Registered($user));
    return redirect(route('admin_list'));
    }
    //Adminユーザー変更
    public function changeAdmin(Request $request){
        print_r($request->all());
        $user = Admin::find($request->change_id);
        if($request->change_name != ""){
            $user->name = $request->change_name;
        }
        if($request->change_pass != "" && strlen($request->change_pass) >=8){//strlenは文字列の長さを調べる
            $user->password = Hash::make($request->change_pass);
        }
        $user->save();
        return;
    }
    
    //Adminユーザー削除
    public function deleteAdmin(Request $request){
        print_r($request->all());
        $pictures = Picture::where('u_id',$request->delete_id)->get();
        foreach($pictures as $picture){
            //print $picture->file_name;
            //print $picture->thumb_name;
            //画像データ削除
            Storage::delete("main_images/" . $picture->file_name);
            Storage::delete("thumb_images/" . $picture->thumb_name);
        }
        //Pictureテーブルから該当ユーザーのデータの一括削除
        Picture::where('u_id',$request->delete_id)->delete();
        //Userテーブルからユーザを削除
        Admin::destroy($request->delete_id);
        return;
    }
}
