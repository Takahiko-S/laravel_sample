{{$request->u_name}} 様

この度はお問い合わせいただきありがとうございます。
のちほど担当者よりご連絡致します。
しばらくお待ちください。


-------------お問い合わせ内容------------------
送信日時 ： <?php print date("Y-m-d H:i:s");?>

お名前 ：{{$request->u_name}}
メールアドレス ： {{$request->u_mail}}
電話番号 ： {{$request->u_tel}}
郵便番号 ： {{$request->u_yubin}}
住所 ： {{$request->u_jusho1 . $request->u_jusho2 . $request->u_jusho3}}
お問い合わせ内容 ：
{{$request->u_message}}
----------------------------------------------
みんなのアルバム
サイト管理者

URL: http://localhost/laravel_sample
Mail: webmaster@localhost.localdomain