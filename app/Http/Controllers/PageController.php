<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Picture;

class PageController extends Controller//ユーザーのアルバムがホームに表示されるようになる
{
    public function top(){//DBから各ユーザーの最新の画像データを取得し、それらの画像データをBase64エンコーディングして配列に格納し、最後にその配列をビューに渡して表示する処理
        $image_array=array();
        $user_list= User::all();
        foreach ($user_list as $user){
            $picture = Picture::where('u_id',$user->id)->orderBy('id','desc')->first();//逆順に並べた最初のデータを引っ張る
            if($picture != null){
                $thumb = file_get_contents(storage_path(('app/thumb_images/' . $picture -> thumb_name)));
                $p_info = pathinfo($picture->thumb_name);
                $ext = $p_info['extension'];
                if($ext =="png" || $ext =="PNG"){
                        $type = "data:images/png;base64,";
                        
                }else{
                        $type = "data:images/jpeg;base64,";
                }
                $image_array[] = array('id'=>$user->id,'user_name'=>$user->name,'img' => $type . base64_encode($thumb));
                
            }
        }
       // dd($image_array);
        return view('contents.index',compact('image_array'));

    }
    public function showAlbum(Request $request){
        //dd($request->all());//戻るとエラー出る。
        $user = User::find($request->uid);
        if($user == null){
            exit('不正なアクセスです');//ブラウザで適当な番号入れるとメッセージ表示される
        }
        $user_name = $user->name;
        $user_id = $user->id;
        
        
        return view('contents.show_album',compact('user_name','user_id'));
        
    }
    public function userPics(Request $request){
     
            $user_id = $request->u_id;
            $page_count = 24;
            $page_num =$request->page_num;
            
            $file_list = Picture::select('id','thumb_name','title')->where('u_id',$user_id)->orderBy('id','desc')->get();
            //dd($file_list);エラー出る
            //ファイルがないときは戻す
            if(count($file_list) < 1){
                return;
            }
            //ページ配列の組み立て
            $page_array=array();
            $array_count = 0;
            $count = 0;
            for($i = 0; $i < count($file_list); $i++){
                $page_array[$array_count][$count] = $file_list[$i];
                $count++;
                if($count == $page_count){
                    $count = 0;
                    $array_count++;
                }
            }
            $data_list = array();
            if(count($page_array) <= $page_num){
                $page_num--;
            }
            foreach ($page_array[$page_num] as $file){
                $thumb = file_get_contents(storage_path("app/thumb_images/" . $file->thumb_name));
                $p_info = pathinfo($file->thumb_name);
                $ext = $p_info['extension'];
                if($ext =="png" || $ext =="PNG"){
                    $type = "data:images/png;base64,";
                }else{
                    $type = "data:images/jpeg;base64,";
                }
                $data_list[] = array('id' => $file->id, 'img' =>$type . base64_encode($thumb),'title' => $file ->title);
                
            }
            $tab_count = count($page_array);
            
            
            
            return view('ajax.list_only_guest',compact('data_list','tab_count','page_num'));
        
    }    
    public function showMaster(Request $request) {
        $img_id = $request->image_id;
        $data = Picture::find($img_id);
        $img_name = $data->file_name;
        
        $image = file_get_contents(storage_path("app/main_images/" . $img_name));
        $p_info = pathinfo($img_name);
        $ext = $p_info['extension'];
        if($ext =="png" || $ext =="PNG"){
            $type = "data:images/png;base64,";
        }else{
            $type = "data:images/jpeg;base64,";
        }
        $master_data = array($data->title,$type . base64_encode($image));
        
        
        return $master_data;
    }
}
