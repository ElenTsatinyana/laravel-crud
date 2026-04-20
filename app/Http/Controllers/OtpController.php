<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $code = rand(100000, 999999);

        Otp::updateOrCreate(
            ['phone' => $request->phone],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(5)
            ]
        );

        return redirect('/verify-otp')->with('phone', $request->phone);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'code' => 'required'
        ]);

        $otp = Otp::where('phone', $request->phone)
                  ->where('code', $request->code)
                  ->first();

        if (!$otp) {
            return back()->withErrors(['code' => 'Invalid code']);
        }

        if ($otp->expires_at < now()) {
            return back()->withErrors(['code' => 'Code expired']);
        }

        $user = auth()->user();

        $user->role = 'editor';
        $user->save();

        return redirect('/posts')->with('success', 'You are now editor!');
    }
}