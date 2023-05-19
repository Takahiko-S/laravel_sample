<x-app-layout>
<x-slot name="title">登録情報変更</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('登録情報変更') }}
        </h2>
    </x-slot>


<x-slot name="main">
<div class="container">
	<div class="row pt-5">
	<div class="col-md-2 mb-3">ID : {{$user->id}}</div>
	<div class="col-md-5 mb-3">名前 : {{$user->name}}</div>
	<div class="col-md-5 mb-3">メール : {{$user->email}}</div>
		<div class="col-12">
		  <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
			<form method="post" action="./save_data" class="row h-adr">
			
     			 <span class="p-country-name" style="display:none;">Japan</span>
     			   @csrf
				<div class="col-md-2 mb-3">
					<label for="yubin" class="form-label">郵便番号</label> 
					<input type="text" class="form-control p-postal-code" id="yubin" name="yubin" value="{{$user_data->yubin}}">
				</div>
				<div class="col-md-2 mb-3">
					<label for="yubin" class="form-label">都道府県</label> 
					<input type="text" class="form-control p-region" id="jusho1" name="jusho1" value="{{$user_data->jusho1}}">
				</div>
				<div class="col-md-4 mb-3">
					<label for="yubin" class="form-label">市区町村</label> 
					<input type="text" class="form-control p-locality p-street-address" id="jusho2" name="jusho2" value="{{$user_data->jusho2}}">
				</div>
				<div class="col-md-4 mb-3">
					<label for="yubin" class="form-label">番地・建物</label> 
					<input type="text" class="form-control" id="jusho3" name="jusho3" value="{{$user_data->jusho3}}">
				</div>
				<div class="col-md-2 mb-3">
					<label for="yubin" class="form-label">電話番号</label> 
					<input type="text" class="form-control" id="tel" name="tel" value="{{$user_data->tel}}">
				</div>
				<div class="col-md-10 mb-5">
					<label for="yubin" class="form-label">備考</label> 
					<input type="text" class="form-control" id="biko" name="biko" value="{{$user_data->biko}}">
				</div>
				<div class="col-md-10 mb-3">
				<button type="reset" class="btn btn-secondary">リセット</button>
				<button type="submit" class="btn btn-primary">登録情報更新</button>
				</div>
			</form>
		</div>
	</div>
</div>
</x-slot>
    
<x-slot name="script">

</x-slot>
</x-app-layout>
