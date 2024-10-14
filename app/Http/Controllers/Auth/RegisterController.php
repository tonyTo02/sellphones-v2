<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Models\EmailVerification;
use App\Notifications\SendingOtpCodeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function loadRegisterForm()
    {
        return view('auth.register');
    }

    public function verifyEmail(StoreCustomerRequest $request)
    {
        $fullRequest = $request->validated();
        session()->put('customerRequest', $fullRequest);
        $otp_code = rand(100000, 999999);
        $verification = new EmailVerification();
        $object = $verification::create([
            'email' => $request->input('email'),
            'otp_code' => $otp_code,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
        $verify = $verification::find($object->id);
        session()->put('customerEmail', $verify->email);
        $verify->notify(new SendingOtpCodeNotification($verify));
        return redirect()->route('auth.register.otp.form');
    }

    public function loadRegisterOtpForm()
    {
        return view('auth.otp');
    }
    public function registerNew(Request $request)
    {
        $fullRequest = session()->get('customerRequest');
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required'
        ]);

        $verification = EmailVerification::where('email', '=', $request->input('email'))
            ->where('otp_code', '=', $request->input('otp_code'))
            ->first();
        if ($verification) {
            $customer = new Customer();
            $customer::create([
                'name' => $fullRequest['name'],
                'gender' => $fullRequest['gender'],
                'dob' => $fullRequest['dob'],
                'email' => $fullRequest['email'],
                'password' => Hash::make($fullRequest['password']),
                'address' => $fullRequest['address'],
                'phone_number' => $fullRequest['phone_number'],
            ]);
            $verification->delete();
            session()->forget('customerRequest');
            session()->forget('emailCustomer');
            return redirect()->route('auth.login')->with('success', 'Tạo tài khoản thành công!');
        } else {
            return back()->withErrors(['otp_code' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']);
        }
    }
}
