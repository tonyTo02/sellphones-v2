<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Customer();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $data = $this->model::query()
            ->where('name', 'like', '%' . $search . '%')
            ->paginate(10);
        return view('customer.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $path = Storage::disk('public')->putFile('avatars', $request->file('avatar'));
        $arr = $request->validated();
        $arr['avatar'] = $path;
        $arr['password'] = Hash::make($arr['password']);
        $this->model::create($arr);
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer, $id)
    {
        $object = $this->model::query()->find($id);
        return view('customer.edit', [
            'each' => $object
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $customer)
    {
        $object = $this->model::query()->find($customer);
        $arr = $request->validated();
        $arr['password'] = Hash::make($arr['password']);
        $object->update($arr);
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer, $id)
    {
        $this->model->destroy($id);
        return redirect()->route('customer.index');
    }
}
