<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $details = [
            'title' => 'أهلاً بك!',
            'body' => 'هذه رسالة تجريبية من API باستخدام Gmail.'
        ];

        Mail::to($request->email)->send(new TestMail($details));

        return response()->json(['message' => 'تم إرسال البريد بنجاح!']);
    }
}
