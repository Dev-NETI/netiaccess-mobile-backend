<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendVerificationCode($recipient, $verificationCode)
    {
        $sendEmail = Mail::to($recipient)
            ->cc('sherwin.roxas@neti.com.ph')
            ->send(new VerificationCodeEmail($verificationCode));

        return response()->json($sendEmail);
    }
}
