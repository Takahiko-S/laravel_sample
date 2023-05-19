<x-admin><!-- 管理者管理 -->

<x-slot name="title">管理者管理</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('管理者管理') }}
        </h2>

                 <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
          新規登録
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新規登録</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              
               <form method="post" action="./save_admin">
                   <div class="modal-body">
                   @csrf
                   <div class="mb-3">
                    <label for="name" class="form-label">登録名</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                   </div>
                    <div class="mb-3">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                   </div>
                   <div class="mb-3">
                    <label for="password" class="form-label">パスワード</label>
                    <input type="text" class="form-control" id="password" name="password" minlength="8" required>
                   </div>
                               
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">登録 </button>
                  </div>
               </form>
            </div>
          </div>
        </div>
        
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
        				@if($user->id !=1)<!-- １つは絶対 -->
        				<button class="btn btn-sm btn-danger delete_bt" value="{{$user->id}}">削除</button>
        				@endif
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
<p>上記の管理者を削除しますか？</p>
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
    <p>上記の管理者を変更しますか？</p>
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
		url: "./change_admin",  //送信先
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
		url: "./delete_admin",  //送信先
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
