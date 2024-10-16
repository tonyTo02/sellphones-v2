<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SlideShow;
use App\Notifications\TesttingNotificationMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Stripe;

class GuestController extends Controller
{
    public function __construct()
    {
        session()->put('product', []);
    }
    public function index(Request $request)
    {
        $product = new Product();
        $slideshow = new SlideShow();
        $search = $request->get('search');
        $data = $product->leftJoin('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
            ->select('products.*', 'manufacturers.name as manufacturer_name')
            ->where('products.name', 'like', '%' . $search . '%')
            ->orderBy('products.id')
            ->paginate(9);

        $images = $slideshow::query()->get();
        return view('welcome', [
            'data' => $data,
            'images' => $images,
        ]);
    }
    public function viewCart()
    {
        $cart = session()->get('product', []);
        return view('guess.cart', [
            'data' => $cart,
        ]);
    }
    public function removeProductFromCart($id)
    {
        $cart = session()->get('product');
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        session(['product' => $cart]);
        return back()->with('removeMessage', 'Xóa thành công!');
    }

    public function addToCart($id)
    {
        $product = new Product();
        $object = $product::query()->findOrFail($id);
        $cart = session()->get('product', []);
        if (isset($cart[$object->id])) {
            $cart[$object->id]['quantity'] += 1;
        } else {
            $cart[$object->id] = [
                'name' => $object->name,
                'price' => $object->price,
                'description' => $object->description,
                'image' => $object->image,
                'quantity' => 1,
            ];
        }
        session()->put('product', $cart);
        $message = "Đã thêm vào giỏ hàng!";
        session()->reflash();
        return back()->with('message', $message);
    }

    public function cashOut()
    {
        $cart = session()->get('product', []);
        $totalCart = 0;
        foreach ($cart as $each) {
            $totalCart += $each['price'] * $each['quantity'];
        }
        session()->put('totalCart', $totalCart);
        if (!$cart) {
            return redirect()->route('homepage')->with('message', 'Vui lòng chọn sản phẩm trước khi thanh toán');
        }
        return view('guess.cashout', [
            'data' => $cart,
        ]);
    }

    public function cashOutProcess(StoreBillRequest $request)
    {
        try {
            $cart = session()->get('product', []);

            //session()->get('totalCart) take from $this->cashOut() - function cashOut() above
            $totalCart = session()->get('totalCart');
            if ($request->total !== $totalCart) {
                return back()->with('message', "Something Is Wrong With You!!!");
            }
            $bill = new Bill();
            $billDetail = new BillDetail();
            $customer = new Customer();
            //Validate Customer Information's Form
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'phone_number' => 'required|min:10|max:10',
            ]);

            if (Auth::guard('customer')->user()) {
                //Update Customer Infor In case they have another infor
                $objectCustomer = $customer::find($request->get('customer_id'));
                $objectCustomer->update([
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'phone_number' => $request->input('phone_number'),
                ]);
                //Create Bill
                $object = $bill::create($request->validated());

                //Create Detail Bill - With Each Product In Cart
                foreach ($cart as $key => $value) {
                    $createBillDetail = $billDetail::create([
                        'bill_id' => $object->id,
                        'product_id' => $key,
                        'quantity' => $value['quantity'],
                    ]);
                }
                // create Stripe Payment
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $token = $request->stripeToken;
                try {
                    $charge = Charge::create([
                        'amount' => $object->total, // Số tiền (đơn vị là cents, 1000 = 10 USD)
                        'currency' => 'usd', // Đơn vị tiền tệ
                        'description' => 'Thanh toán đơn hàng từ SellphoneS',
                        'source' => $token,
                        'receipt_email' => $objectCustomer->email,
                        'metadata' => [
                            'bill_id' => $object->id,
                        ]
                    ]);
                } catch (Exception $e) {
                    dd($e);
                    return redirect()->route('guess.cash.out')->with('error', 'Thanh toán không thành công! Lỗi: ' . $e->getMessage());
                }
                //End Payment

                //Send Email To Customer About Order's Information
                $user = Auth::guard('customer')->user();
                $user->notify(new TesttingNotificationMail($object, $user));
                return redirect()->route('auth.dashboard')->with("message", "Bạn vừa thanh toán thành công đơn hàng: " . $object->id);
            }
        } catch (Exception $e) {
            return back()->with('message', 'Something Went Wrong! Please Try Again!');
        }
    }

    public function showDetailProduct($product)
    {
        $this_product = new Product();
        $this_product_images = new ProductImage();
        $object = $this_product::query()->find($product);
        $images = $this_product_images::query()->where('product_id', '=', $product)->get();
        return view('guess.detail', [
            'data' => $object,
            'images' => $images
        ]);
    }

    public function addToCartFormDetailProduct($id, Request $request)
    {
        $product = new Product();
        $object = $product::query()->find($id);
        $cart = session()->get('product', []);
        if (isset($cart[$object->id])) {
            $cart[$object->id]['quantity'] += 1;
        } else {
            $cart[$object->id] = [
                'name' => $object->name,
                'price' => $object->price,
                'description' => $object->description,
                'image' => $object->image,
                'quantity' => $request->get('quantity'),
            ];
        }
        session()->put('product', $cart);
        $message = "Đã thêm vào giỏ hàng!";
        session()->reflash();
        return back()->with('message', $message);
    }
}
