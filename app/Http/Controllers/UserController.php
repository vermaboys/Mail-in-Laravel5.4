<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SentData;
use Session;
class UserController extends Controller
{
    function contactUs(){
    	return view('contactus');
    }
    
    function sendEmail(Request $request){
    	$name=$request->name;
        $email=$request->email;
        $subject="Thanks for email";
        $description=$name;
        Mail::to($email)->send(new SentData($description,$subject));
        Session::flash('message', 'Mail sent succuessfully');
        return redirect()->back();
    }
    
}
