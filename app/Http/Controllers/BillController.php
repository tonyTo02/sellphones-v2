<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
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
        $data = $this->model::join('customers', 'bills.customer_id', '=', 'customers.id')
            ->select('bills.*', 'customers.name', 'customers.address', 'customers.phone_number')
            ->where('customers.name', 'like', '%' . $search . '%')
            ->orderBy('bills.id')
            ->paginate(10);
        return view('bill.index', [
            'data' => $data,
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
}
