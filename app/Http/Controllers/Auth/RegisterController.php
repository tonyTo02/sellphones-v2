<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;

class RegisterController extends Controller
{
    public function loadRegisterForm()
    {
        return view('auth.register');
    }
    public function registerNew(StoreCustomerRequest $request)
    {
        $customer = new Customer();
        $customer::create($request->validated());
        return redirect()->route('auth.login');
    }
}
