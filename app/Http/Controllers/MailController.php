<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index(Request $request = null,$senderEmail,$recieverEmail, $header,$message){
        $to = $recieverEmail; // this is your Email address
        $from = $senderEmail; // this is the sender's Email address
        $subject = $header;
        $message = $message;

        $headers = "From:" . $from;
        $headers = "Content-type: text/html\r\n";
        $headers = "Reply-To:" . $from;

        //send mail
        mail($to,$subject,$message,$headers);
    }
}
