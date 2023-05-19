<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryMail;


class MailController extends Controller
{
    public function inquiryMail(Request $request){//重要
        //dd($request->all());
        Mail::to($request->u_mail)->bcc('webmaster@localhost.localdomain')
        ->send(new InquiryMail($request));
        
        return view('contents.thanks');
    }
}
