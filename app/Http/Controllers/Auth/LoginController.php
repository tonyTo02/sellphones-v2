<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BillController;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class LoginController extends Controller
{
    public function loadLoginForm()
    {
        return view('auth.login');
    }
    public function checkLogin(Request $request)
    {
        $customer = new Customer();
        $email = $request->input('email');
        $password = $request->input('password');
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];
        $object = $customer::query()->where('email', '=', $email)->first();
        if (Auth::guard('customer')->attempt($credentials)) {
            Auth::login($object);
            return redirect()->route('homepage')->with('message', 'Xin chào');
        } else {
            return back()->with('Fail', 'Email hoac mat khau khong chinh xacs');
        }
    }

    public function dashboard()
    {
        if (Auth::guard('customer')->user()) {
            $customer = Auth::guard('customer')->user();
            $bill = new BillController();
            $order = $bill->listOrderCustomer($customer->id);
            return view('auth.dashboard', [
                'customer' => $customer,
                'order' => $order,
            ]);
        }
        return redirect()->route('auth.login');
    }
    public function logOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
