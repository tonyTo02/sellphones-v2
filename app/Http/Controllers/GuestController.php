<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillCustomerRequest;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class GuestController extends Controller
{
    public function __construct()
    {
        session()->put('product', []);
    }
    public function index(Request $request)
    {
        $product = new Product();
        $search = $request->get('q');
        $data = $product->leftJoin('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
            ->select('products.*', 'manufacturers.name as manufacturer_name')
            ->where('products.name', 'like', '%' . $search . '%')
            ->orderBy('products.id')
            ->paginate(9);
        return view('welcome', [
            'data' => $data,
        ]);
    }
    public function viewCart()
    {
        $cart = session()->get('product', []);
        return view('guess.cart', [
            'data' => $cart,
        ]);
        // return response()->json($cart['1']['name']);
    }

    public function addToCart($id)
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
        if (!$cart) {
            return redirect()->route('homepage')->with('message', 'Vui lòng chọn sản phẩm trước khi thanh toán');
        }
        return view('guess.cashout', [
            'data' => $cart,
        ]);
    }
    public function cashOutProcess(StoreBillRequest $request)
    {
        $bill = new Bill();
        if (Auth::user()) {
            $object = $bill::create($request->validated());
            return redirect()->route('homepage')->with('message', 'Đơn hàng của bạn đã đặt thành công. Vui lòng kiểm tra đơn hàng tại trang thông tin người dùng');
        }
        return redirect()->route('homepage')->with('message', 'Vui Lòng đăng nhập trước khi tiến hành thanh toán');
    }
}
