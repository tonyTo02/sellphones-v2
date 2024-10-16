<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        //Take All Transaction From Stripe.com
        $transactions = Charge::all();

        //Just Want Transaction Which Have Been Refunded Or Opposite
        $transactions = array_filter($transactions->data, function ($charge) {
            return $charge->refunded === false;
        });
        return view('transaction.index', [
            'data' => $transactions,
        ]);
    }

}
