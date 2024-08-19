<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\BillDetail;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Bill();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $billID = $request->get('id');
        $data = $this->model::join('customers', 'bills.customer_id', '=', 'customers.id')
            ->select('bills.*', 'customers.name', 'customers.address', 'customers.phone_number')
            ->where('customers.name', 'like', '%' . $search . '%')
            ->orderBy('bills.id')
            ->paginate(10);
        $detailBill = $this->detailBill($billID);
        // return response()->json($detailBill);
        return view('bill.index', [
            'data' => $data,
            'detailBill' => $detailBill,
        ]);
    }

    public function api()
    {
        return response()->json();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bill.create');
    }
    public function updateCartForGuess($quantity)
    {
        $cart = session()->get('product', []);
        foreach ($cart as $key => $value) {
            if (isset($cart[$key])) {
                $cart[$key]['quantity'] = $quantity;
            }
        }
        session()->put('product', $cart);
        session()->reflash();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBillRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route('bill.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill, $id)
    {
        $data = $this->model::join('customers', 'bills.customer_id', '=', 'customers.id')
            ->select('bills.*', 'customers.name', 'customers.address', 'customers.phone_number')
            ->find($id);
        $billStatus = $this->model->getKeyValueToStatusOption();
        return view('bill.edit', [
            'each' => $data,
            'billStatus' => $billStatus
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBillRequest $request, $bill)
    {
        $object = $this->model::query()->find($bill);
        $object->update($request->validated());
        return redirect()->route('bill.index')->with('success', 'ádasdasd');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill, $id)
    {
        $this->model->destroy($id);
        return redirect()->route('bill.index');
    }


    private function detailBill($billID)
    {
        /*
            SELECT bill_details.*, products.name, products.price, bills.total
            FROM bill_details
            LEFT JOIN bills on bills.id = bill_details.bill_id
            LEFT JOIN products on products.id = bill_details.product_id
        */

        $detailBill = new BillDetail();
        $object = $detailBill::leftJoin('bills', 'bills.id', '=', 'bill_details.bill_id')
            ->leftJoin('products', 'products.id', '=', 'bill_details.product_id')
            ->select('bill_details.*', 'products.name', 'products.price', 'bills.total')
            ->where('bill_details.bill_id', '=', $billID)
            ->get();
        // ->orderBy('bill_details.bill_id');
        return $object;
    }

    public function listOrderCustomer($customerID)
    {
        $data = $this->model::join('customers', 'bills.customer_id', '=', 'customers.id')
            ->select('bills.*')
            ->where('bills.customer_id', '=', $customerID)
            ->get();
        return $data;
    }
}
