<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new Product();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('q');
        $data = $this->model->leftJoin('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
            ->select('products.*', 'manufacturers.name as manufacturer_name')
            ->where('products.name', 'like', '%' . $search . '%')
            ->orderBy('products.id')
            ->paginate(10);
        return view('product.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manufacturer = new Manufacturer();
        $each = $manufacturer->getSelectOptionManufacturer();
        return view('product.create', [
            'each' => $each,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product_images = new ProductImage();
        $file = $request->file('more_images');
        $path = Storage::disk('public')->putFile('product_images', $request->file('image'));
        $arr = $request->validated();
        $arr['image'] = $path;
        $product = $this->model::create($arr);
        if ($request->hasFile('more_images')) {
            foreach ($file as $image) {
                $newPath = Storage::disk('public')->putFile('product_images', $image);
                $object = $product_images::create([
                    'product_id' => $product->id,
                    'image_path' => $newPath,
                ]);
            }
        }
        return redirect()->route('product.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show($product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, $id)
    {
        $object = $this->model::query()->find($id);
        $manufacturer = new Manufacturer();
        $selectOption = $manufacturer->getSelectOptionManufacturer();
        return view('product.edit', [
            'each' => $object,
            'selectOption' => $selectOption,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $product)
    {
        $object = $this->model::query()->find($product);
        $object->update($request->validated());
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = $this->model::findOrFail($id);
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
        $this->model->destroy($id);
        return redirect()->route('product.index');
    }
}
