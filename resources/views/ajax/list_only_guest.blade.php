	<div class="row">
		<div class="col-12 text-center">
		@for($i = 0; $i < $tab_count; $i++)
    		@if($i == $page_num)
    	
    		<button class="btn btn-primary btn-sm page_bt" value="{{$i}}">{{$i + 1}}</button>
    		@else
    		<button class="btn btn-outline-primary btn-sm page_bt" value="{{$i}}">{{$i + 1}}</button>
    		@endif
		@endfor
		</div>
		<div class="col-12">
			<div class="row">
				@foreach($data_list as $list)
				<div class="col-6 col-md-2 p-1">
					<img src="{{$list['img']}}" class="w-100 show_pic" value="{{$list['id']}}">
					<p>{{$list['title']}}</p>
				</div>
				@endforeach
			</div>
		</div>
			<div class="col-12 text-center">
		@for($i = 0; $i < $tab_count; $i++)
    		@if($i == $page_num)
    		<button class= "btn btn-primary btn-sm page_bt" value="{{$i}}">{{$i + 1}}</button>
    		@else
    		<button class= "btn btn-outline-primary btn-sm page_bt" value="{{$i}}">{{$i + 1}}</button>
    		@endif
		@endfor
		</div>
	</div>
<script>
$('.page_bt').on('click',function(e){
	changeContents($(this).attr('value'));
	 page_num = $(this).attr('value');
	});
$('.show_pic').on('click',function(e){
	console.log($(this).attr('value'));
	openModal($(this).attr('value'));
});
</script>
