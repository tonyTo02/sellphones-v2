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
        $customer = new Customer();
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|min:10|max:10',
        ]);
        if (Auth::guard('customer')->user()) {
            $object = $customer::find($request->get('customer_id'));
            $object->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
            ]);
            $object = $bill::create($request->validated());
            foreach ($cart as $key => $value) {
                $createBillDetail = $billDetail::create([
                    'bill_id' => $object->id,
                    'product_id' => $key,
                    'quantity' => $value['quantity'],
                ]);
            }
            //Gửi mail
            $user = Auth::guard('customer')->user();
            $user->notify(new TesttingNotificationMail($object, $user));
            return redirect()->route('homepage')->with('message', 'Đơn hàng của bạn đã đặt thành công. Vui lòng kiểm tra đơn hàng tại trang thông tin người dùng');
        }
        return redirect()->route('homepage')->with('message', 'Vui Lòng đăng nhập trước khi tiến hành thanh toán');
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
