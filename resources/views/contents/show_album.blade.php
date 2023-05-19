<x-page-base>
<x-slot name="title">アルバム</x-slot>

<x-slot name="main">
<div class= "container">
	<div class="row">
		<div class="col-12">
			<h1 class="text-center mb-4">{{$user_name}}さんのアルバム</h1>
			<input type="hidden" id = "u_id" value= "{{$user_id}}">
			@csrf
		</div>
	</div>
	<div class="row">
		<div id="list_area"></div>
	</div>
</div>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modal_bt" style="display:none">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">画像確認</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" class="w-100" id="modal_image" value="">
        <p  id="pic_title" class = "p-2"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">確認</button>
        
      </div>
    </div>
  </div>
</div>
</x-slot>
<x-slot name="script">
<script>

var page_num = (0);
changeContents(0);
function changeContents(num){
	document.body.style.cursor = 'wait';//waitはマウスカーソルがくるくるしてる状態 ここからajax
	//FormDataオブジェクトを用意
	let code = document.getElementsByName("_token").item(0).value;
	let user_id = $("#u_id").val();
	var fd = new FormData();//変数fdにFormDataをセット
	fd.append("_token",code);
	fd.append("u_id",user_id);
	fd.append("page_num",num);
	
	

	//XHRで送信
	$.ajax({
		url: "./user_pics",  //送信先
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
			$('#list_area').html(res);
		
			document.body.style.cursor = 'auto';
			//location.reload();

			});//ここまでajax
}
function openModal(num){
	document.body.style.cursor = 'wait';//waitはマウスカーソルがくるくるしてる状態 ここからajax
	//FormDataオブジェクトを用意
	let code = document.getElementsByName("_token").item(0).value;
	let user_id = $("#u_id").val;
	var fd = new FormData();//変数fdにFormDataをセット
	fd.append("_token",code);
	fd.append("image_id",num);

	
	

	//XHRで送信
	$.ajax({
		url: "./show_master",  //送信先
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
			$('#modal_image').attr('src',res[1]);
			$('#modal_image').attr('value',num);
			$('#pic_title').html(res[0]);
			$('#modal_bt').trigger('click'); 
			
			document.body.style.cursor = 'auto';
			//location.reload();

			});//ここまでajax
}
</script>
</x-slot>

</x-page-base>