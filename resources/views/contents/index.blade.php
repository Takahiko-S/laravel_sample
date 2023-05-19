<x-page-base>
<x-slot name="title">ホーム</x-slot>

<x-slot name="main">
<div class= "container">
	<div class="row">
		<div class="col-12">
			<h1 class="text-center">みんなのアルバム</h1>

		</div>
	</div>
	<div class="row">
		@foreach($image_array as $image)
		<div class="col-md-3 p-1">
			<form method="post" action="show_album">
			<input type ="hidden" name="uid" value="{{$image['id']}}">
			@csrf
				<div class="border p-1">
					<p>{{$image['user_name']}}</p>
					<p>
						<input type="image" src="{{$image['img']}}" class="w-100 show_all pointer"
							tag="{{$image['id']}}">
					</p>
				</div>
			</form>
		</div>
		@endforeach
	</div>
	
</div>


</x-slot>
<x-slot name="script">
<script>
 $('.show_all').on('click',function(e){
	var user_id = $(this).attr('tag');//user_idに.show_allのtagが入る
	console.log(user_id);
	location.replace('show_album?uid='+ user_id);//ページ移動、idが表示される　飛び先のページにshow_album?uid+user_idを持って移動
	
	}); 
	
</script>
</x-slot>

</x-page-base>