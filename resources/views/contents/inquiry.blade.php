<x-page-base>
<x-slot name="title">お問い合わせ</x-slot>

<x-slot name="main">
<div class="container">
		 <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
	<div class="row">
		<div class="col-12">
			<h1 class="text-info text-center">お問い合わせ</h1>

		</div>
	</div>
	<div class="row">
		<div class="col-md-8 mx-auto mt-2 p-5">
			<form method="post" action="./guest_inquiry"
				class="row g-3 h-adr pt-3">
             <span class="p-country-name" style="display:none;">Japan</span>
            @csrf

				<div class="col-sm-6 mb-3">
					<label for="u_name" class="form-label">お名前</label> <input
						type="text" class="form-control" id="u_name" name="u_name">
				</div>
				<div class="col-md-6 mb-3">
					<label for="u_mail" class="form-label">メールアドレス</label> <input
						type="email" class="form-control" id="u_mail" name="u_mail" required>
				</div>
				<div class="col-md-3 mb-3">
					<label for="u_yubin" class="form-label">郵便番号</label> <input
						type="text" class="form-control p-postal-code" maxlength="8" id="u_yubin" name="u_yubin">
				</div>
				<div class="col-md-3 mb-3">
					<label for="u_jusho1" class="form-label">都道府県</label> <input
						type="text" class="form-control p-region" id="u_jusho1" name="u_jusho1" required>
				</div>
				<div class="col-md-6 mb-3">
					<label for="u_jusho2" class="form-label">市区町村・番地</label> <input
						type="text" class="form-control p-locality p-street-address" id="u_jusho2" name="u_jusho2" required>
				</div>
				<div class="col-md-6 mb-3">
					<label for="u_jusho3" class="form-label">建物名</label> <input
						type="text" class="form-control" id="u_jusho3" name="u_jusho3" required>
				</div>
				<div class="col-md-6 mb-3">
					<label for="u_tel" class="form-label">電話番号</label> <input
						type="text" class="form-control" id="u_tel" name="u_tel" required>
				</div>
				<div class="mb-3">
					<label for="u_message" class="form-label">お問い合わせ内容</label> 
					<textarea class="form-control" id="u_message" rows = "5" name="u_message" required></textarea>
				</div>
				<p class="text-center mt-5">
				<button type="submit" class="btn btn-primary">お問い合わせ</button>
				<button type="reset" class="btn btn-danger">キャンセル</button>
				</p>
			</form>
		</div>
	</div>
</div>
</x-slot>
<x-slot name="script">


</x-slot>

</x-page-base>