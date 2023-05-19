<x-admin><!-- 編集と削除のダイアログ P277-->
<x-slot name="title">会員管理</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('会員管理') }}
        </h2>
    </x-slot> 
    
<x-slot name="main">
    <div class="container">
    	<div class="row mt-5">
    		<div class="col-12">
    		@csrf
    		<table class="table table-striped">
        		<thead>
            		<tr>
                		<th>ID</th>
                		<th>名前</th>
                		<th>メールアドレス</th>
                		<th>登録日</th>
                		<th>管理</th>
            		</tr>
        		</thead>
        		@foreach($user_list as $user)
				<tr>
				<td>{{$user->id}}</td>
				<td id = "name_{{$user->id}}">{{$user->name}}</td>
				<td id = "mail_{{$user->id}}">{{$user->email}}</td>
				<td>{{$user->created_at}}</td>
				<td>
				<button class="btn btn-sm btn-secondary change_bt" value="{{$user->id}}">編集</button>
				<button class="btn btn-sm btn-danger delete_bt" value="{{$user->id}}">削除</button>
				</td>
				</tr>

				@endforeach
        		</table>
    		</div>
    	</div>
    	<div id = "message"></div>
    </div>
 
 <div id="delete_dialog" title = "削除の確認">
<p id="d_name"></p>
<p id="d_mail"></p>
<p>上記のデータを削除しますか？</p>
</div>
 
 
<div id="change_dialog" title = "名前の編集">
    <div class="form-group">
        <lavel for="c_name">名前</lavel>
        <input type ="text" class="form-control mb-3" id="c_name" name="c_name">
        </div>
    <div class="form-group">
        <lavel for="c_pass">パスワード</lavel>
        <input type ="text" class="form-control mb-3" id="c_pass" name="c_pass" placeholder="8文字以上 変更なしは未入力">
    </div>
    <div class="form-group">
        <lavel for="c_mail">メールアドレス</lavel>
        <input type ="text" class="form-control mb-3" id="c_mail" name="c_mail" readonly>
    </div>
    <p id="c_mail" class="pt-3"></p>
    <p>上記のデータを変更しますか？</p>
</div>

</x-slot>
    
<x-slot name="script">
<script>
var change_id=0;
var delete_id=0;

$('.change_bt').on('click',function(e){//削除される
    change_id = $(this).attr('value');
 	let change_name= $('#name_'+change_id).html();
 	let change_mail= $('#mail_'+change_id).html();
 	console.log(change_id);
 	$('#c_name').attr('value',change_name);
 	$('#c_mail').val(change_mail); 
 	$("#change_dialog").dialog('open')
});

    


$('.delete_bt').on('click',function(e){//削除される
	delete_id = $(this).attr('value');
 	let del_name= $('#name_'+delete_id).html();
 	let del_mail= $('#mail_'+delete_id).html();
 	console.log(delete_id);
 	$('#d_name').val(del_name);
 	$('#d_mail').val(del_mail);
 	$('#delete_dialog').dialog('open')
});


$( '#delete_dialog' ).dialog({
    modal: true,
    autoOpen:false,
    resizable:false,
    height:"auto",
    width:"auto",
    fluid:true,
        
    buttons: {
	 "削除する": function() {
             $( this ).dialog( "close" );
             deleteData(delete_id);
          },
        
      "キャンセル": function() {
        $( this ).dialog( "close" );
      }
     
    }
  });
  
$( "#change_dialog" ).dialog({
    modal: true,
    autoOpen:false,
    resizable:false,
    height:"auto",
    width:400,
    fluid:true,
        
    buttons: {
	   "変更する": function() {
    	          $( this ).dialog( "close" );
    	          changeData(change_id);
    	      },
      "キャンセル": function() {
        $( this ).dialog( "close" );
      }
   
    }
  });
function changeData(num){
	document.body.style.cursor = 'wait';//waitはマウスカーソルがくるくるしてる状態 ここからajax
	//FormDataオブジェクトを用意
	let code = document.getElementsByName("_token").item(0).value;
	
	var fd = new FormData();//変数fdにFormDataをセット
	fd.append("_token",code);//パラメーター
	fd.append("change_id",num);
	fd.append("change_name",$('#c_name').val());
	fd.append("change_pass",$('#c_pass').val());
	
	

	//XHRで送信
	$.ajax({
		url: "./change_user",  //送信先
		type:"post",//getでも送れる
		data:fd,
		mode:"multiple",
		async: false,
		processData: false,
		contentType:false,
		timeout: 10000,    //単位はミリ秒
		error:function(XMLHttpRequest,textStatus,errorThrown){
			err=XMLHttpRequest.status+"\n"+XMLHttpRequest.statusText;
			alert(err);
			document.body.style.cursor = 'auto';
			},
			beforeSend:function(xhr){//送信前に何かしたいときにここのカッコに入れる

				}
		})
		.done(function(res){
			//ここは戻ってきた時の処理を記述
			//console.log(res);
			document.body.style.cursor = 'auto';
			location.reload();

			});//ここまでajax
	
}
function deleteData(num){
	document.body.style.cursor = 'wait';//waitはマウスカーソルがくるくるしてる状態 ここからajax
	//FormDataオブジェクトを用意
	let code = document.getElementsByName("_token").item(0).value;
	
	var fd = new FormData();//変数fdにFormDataをセット
	fd.append("_token",code);
	fd.append("delete_id",num);

	
	

	//XHRで送信
	$.ajax({
		url: "./delete_user",  //送信先
		type:"post",//getでも送れる
		data:fd,
		mode:"multiple",
		async: false,
		processData: false,
		contentType:false,
		timeout: 10000,    //単位はミリ秒
		error:function(XMLHttpRequest,textStatus,errorThrown){
			err=XMLHttpRequest.status+"\n"+XMLHttpRequest.statusText;
			alert(err);
			document.body.style.cursor = 'auto';
			},
			beforeSend:function(xhr){//送信前に何かしたいときにここのカッコに入れる

				}
		})
		.done(function(res){
			//ここは戻ってきた時の処理を記述
			//console.log(res);
			document.body.style.cursor = 'auto';
			location.reload();

			});//ここまでajax
}

</script>


</x-slot>
</x-admin>
