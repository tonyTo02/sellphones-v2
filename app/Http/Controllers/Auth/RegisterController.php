<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function loadRegisterForm()
    {
        return view('auth.register');
    }
    public function registerNew(StoreCustomerRequest $request)
    {
        $customer = new Customer();
        $request->validated();
        $customer::create([
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'password' => Hash::make($request->get('password')),
            'dob' => $request->get('dob'),
            'gender' => $request->get('gender'),
            'phone_number' => $request->get('phone_number'),
            'address' => $request->get('address'),
        ]);
        return redirect()->route('auth.login');
    }
}
