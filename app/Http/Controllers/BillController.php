<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Http\Requests\StorebillRequest;
use App\Http\Requests\UpdatebillRequest;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorebillRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatebillRequest $request, bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bill $bill)
    {
        //
    }
}
