<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Http\Requests\StoreManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManufacturerController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Manufacturer();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $data = $this->model::query()->where('name', 'like', '%' . $search . '%')->paginate(10);
        return view('manufacturer.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manufacturer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManufacturerRequest $request)
    {
        $path = Storage::disk('public')->putFile('manufacturer_logo', $request->file('image'));
        $arr = $request->validated();
        $arr['image'] = $path;
        $this->model::create($arr);
        return redirect()->route('manufacturer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturer $manufacturer, $id)
    {
        $object = $this->model::query()->find($id);
        return view('manufacturer.edit', [
            'each' => $object
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManufacturerRequest $request, $manufacturer)
    {
        $object = $this->model::query()->find($manufacturer);
        $object->update($request->validated());
        return redirect()->route('manufacturer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $object = $this->model::findOrFail($id);
        Storage::disk('public')->delete($object->image);
        $this->model->destroy($id);
        return redirect()->route('manufacturer.index');
    }
}
