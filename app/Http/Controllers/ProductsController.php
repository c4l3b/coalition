<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $this->validateProduct($request);

        return Product::query()->create(
            $request->input()
        );
    }

    public function update(Request $request, Product $product)
    {
        $this->validateProduct($request);

        return tap($product)->update(
            $request->input()
        );
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response('', 204);
    }

    protected function validateProduct($request)
    {
        $this->validate($request, [
            'name' => 'required',
            'quantity_in_stock' => 'required|integer',
            'price' => 'required|numeric'
        ]);
    }
}
