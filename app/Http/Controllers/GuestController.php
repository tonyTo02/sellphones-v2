<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $cart = session()->get('product', []);
        $bill = new Bill();
        $billDetail = new BillDetail();
        if (Auth::user()) {
            $object = $bill::create($request->validated());
            foreach ($cart as $key => $value) {
                $createBillDetail = $billDetail::create([
                    'bill_id' => $object->id,
                    'product_id' => $key,
                    'quantity' => $value['quantity'],
                ]);
            }
            return redirect()->route('homepage')->with('message', 'Đơn hàng của bạn đã đặt thành công. Vui lòng kiểm tra đơn hàng tại trang thông tin người dùng');
        }
        return redirect()->route('homepage')->with('message', 'Vui Lòng đăng nhập trước khi tiến hành thanh toán');
    }
}
