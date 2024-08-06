<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        $object = $customer::where('email', '=', $email, 'and', 'password', '=', $password)->get()->first();
        if ($object) {
            Auth::login($object);
            return redirect()->route('homepage');
        } else {
            return back()->with('Fail', 'Email hoac mat khau khong chinh xacs');
        }
    }

    public function logOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
