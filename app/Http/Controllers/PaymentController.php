<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function createPayment($id)
    {
        $bill = new Bill();
        $object = $bill::findOrFail($id);
        return view('guess.payment', [
            'object' => $object,
        ]);
    }
    public function processPayment(Request $request, $id, $amount)
    {
        // Thiết lập API key của Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Nhận token từ form thanh toán
        $token = $request->stripeToken;
        $bill = new Bill();
        $object = $bill::findOrFail($id);
        if ($object->id != $id && $object->total != $amount) {
            return redirect()->route('guess.cash.out')->with("message", 'Something wrong with you!');
        }
        // Tạo thanh toán
        try {
            $charge = Charge::create([
                'amount' => $amount, // Số tiền (đơn vị là cents, 1000 = 10 USD)
                'currency' => 'usd', // Đơn vị tiền tệ
                'description' => 'Thanh toán đơn hàng từ Laravel',
                'source' => $token,
            ]);

            return redirect()->route('auth.dashboard')->with('success', 'Thanh toán thành công!');
        } catch (\Exception $e) {
            return redirect()->route('guess.cash.out')->with('error', 'Thanh toán không thành công! Lỗi: ' . $e->getMessage());
        }
    }
}
