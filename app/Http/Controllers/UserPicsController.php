<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Picture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserPicsController extends Controller
{
    //アップロード画像保存①
    public function savePics(Request $request) {
       // print_r($request->all());//ddと同じ
        //print_r($_FILES);
        //画像チェック   //validateはチェック機能 p144
        $params =$request->validate([
            'upFile' =>'required|file|image|max:50000',   //size＝KB
            ]);
        $file = $params['upFile'];
        //保存用ディレクトリのチェック is_dirがチェック 
        if(!is_dir(storage_path("app/main_images"))){
            mkdir(storage_path("app/main_images"));//もしフォルダがなかったら作る
        }
        if(!is_dir(storage_path("app/thumb_images"))){
            mkdir(storage_path("app/thumb_images"));
        }
        //保存用パス設定
        $image_path = storage_path("app/main_images/");
        $thumb_path = storage_path("app/thumb_images/");
        //画像ファイルの読み込み
        $image = Image::make(file_get_contents($file->getRealPath()));
        //保存するためのランダムファイル名生成
        $temp_name = $file->hashName();
        //print $temp_name;
        
        
        //Main画像を保存②
        $image->resize(1600,1600,function($constrant){
            $constrant->aspectRatio();
        })->save($image_path . $temp_name);
        //thumb画像を保存(サムネイル)
        $f_info = pathinfo($temp_name);
        $thumb_name = $f_info['filename'] . "_thumb." . $f_info['extension'];
        $image->resize(300,300,function($constrant){
            $constrant->aspectRatio();
        })->save($thumb_path . $thumb_name);
        //データベースに保存
        $data = new Picture();
        $data->u_id =$request->u_id;
        $data->file_name = $temp_name;
        $data->thumb_name =$thumb_name;
        $data->title = $request->name;
        $data->save();
        //print_r($data);
        return;
    }
    
    //サムネイルウィンドウ表示③ajax
    public function getPics(Request $request) {
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
        

        
        return view('ajax.list_only',compact('data_list','tab_count','page_num'));
    }
    //マスター画像取得
    public function getMaster(Request $request) {
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
    
    //画像削除（ajax）//phpで削除するのはunlink 
    public function deletePic(Request $request){
        $data = Picture::find($request->image_id);
        //画像を消去
        $master_name = $data->file_name;
        $thumb_name = $data->thumb_name;
       // unlink(storage_path("app/main_images/" . $master_name));旧来の古い書き方
       // unlink(storage_path("app/thumb_images/" . $thumb_name));
        Storage::delete("main_images/" . $master_name);//こっちはlaravelの方法上の書き方と基準のパスがちがう
        Storage::delete("thumb_images/" . $thumb_name);
        //データベース削除
        Picture::destroy($request->image_id);
        return ;
    }
    
    //タイトル変更（ajax
    public function saveTitle(Request $request){
        $data = Picture::find($request->image_id);
        $data->title = $request->title;
        $data->save();
        return;
    }
    
    
    
    
    
    
    
    
    
    
}
