<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function sendContact(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];

        try {
            // Gửi email
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactMail($details));

            // Trả JSON response
            return response()->json(['message' => 'Liên hệ đã được gửi thành công!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gửi liên hệ thất bại.', 'error' => $e->getMessage()], 500);
        }
    }
}
