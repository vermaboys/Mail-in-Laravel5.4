# Mail-in-Laravel5.4

## You Tube ==> https://youtu.be/A93Xsif85rI

## You can get full project of mail using git clone.

```
Firstly Run command on terminal git clone https://github.com/vermaboys/Mail-in-Laravel5.4.git
After that Write Mail Settings in .env file

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=Your-Gmail-Id
MAIL_PASSWORD=Your-Gmail-password
MAIL_ENCRYPTION=tls

Finally you can access using http://localhost/Mail-in-Laravel5.4/contact-us
```

## You can also write all mail's code in your project using following instructions

```
In .env file

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=Your-Gmail-Id
MAIL_PASSWORD=Your-Gmail-password
MAIL_ENCRYPTION=tls
```

```
Route::get('/contact-us','UserController@contactUs');
Route::any('/send-email','UserController@sendEmail'); 
```

```
******mail.php file in config folder******

'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'MyEmail'),
    ],


'stream' => [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ],
```

```
******In UserController******

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
```

```
Run command on terminal php artisan make:mail SentData

Write Code in SentData.php file that is given below


<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SentData extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $data;
    public $subject;
    public function __construct($data,$subject)
    {
        $this->data=$data;
        $this->subject=$subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject($this->subject)->view('emails.send')->with(['description'=>$this->data]);
    }
}
```

```
******contactus.blade in resources\views******

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="background: #000;">
            <div class="card" style="background: rgba(213, 196, 201, 0.6);">
                <div class="card-header">Mail</div>
                @if (session('message'))
                    <div class="alert alert-success alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <p>{{ session('message') }}</p>
                    </div>
                @endif
                <div class="card-body">
                    <form method="post" action="{{url('/send-email')}}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input type="text" id="name" name="name"  class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" id="email" name="email" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

```
******emailLayout.blade in resources\views\layouts******

<html>
<head></head>
<body>
<div class="container">
	<p>Your Header</p>
    @yield('content')
    <p>Your footer</p>
</div>
</body>
</html>
```

```
******send.blade in resources\views\emails******

@extends('layouts.emailLayout')
@section('content')
<body>
<table>
<thead>
<tr>
	<th>Name</th>
</tr>
</thead>
<tbody>
	<tr>
	<th>{{$description}}</th>
</tr>
</tbody>

</table>
@endsection
```

```
Finally you can access using http://localhost/Mail-in-Laravel5.4/contact-us
```
