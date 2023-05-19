<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserData;

class MembersController extends Controller
{
    //ユーザーデータ表示
    public function modify(){
        $u_id =Auth::user()->id;
        $user_data = UserData::where('u_id',$u_id)->first();//本と書き方違うけどこの方が効率的
        //dd($user_data);
        //ユーザーデータのレコードが内場合は新規作成
        if($user_data == null){
            $user_data= new UserData();
            $user_data->u_id =$u_id;
            $user_data->save();
            
           
        }
        $user = Auth::user();
        return view('users.user_data',compact('user_data','user'));
    }
    
    //データ保存
    public function saveData(Request $request){
        //dd($request->all());
        $u_id =Auth::user()->id;
        $user_data = UserData::where('u_id',$u_id)->first();
        $user_data->yubin = $request->yubin;
        $user_data->jusho1 = $request->jusho1;
        $user_data->jusho2 = $request->jusho2;
        $user_data->jusho3 = $request->jusho3;
        $user_data->tel = $request->tel;
        $user_data->biko = $request->biko;
        $user_data->save();
        
        return redirect(route('dashboard'));
    }
    
}
