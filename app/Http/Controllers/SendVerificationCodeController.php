<?php

namespace App\Http\Controllers;

use App\Mail\SendVerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        Mail::to('sherwin.roxas@neti.com.ph')
            ->send(new SendVerificationCodeMail());
    }
}
