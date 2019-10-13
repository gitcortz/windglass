<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Traits\Paginatable;
use Validator;

class ProductController extends Controller
{
    use Paginatable;

    public function index()
    {
        return Product::paginate($this->getPerPage());
    }
 
    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $rules = array (
            'name' => 'required|max:255',
            'type' => 'required|max:50',
            'price' => 'required|numeric',
        );

        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($request->all(), $rules);
        if ($validator-> fails()){
            return response()->json($validator->errors(), 400);
        }
        else{
            $product = Product::create($request->all());
            return response()->json($product, 201);
        }
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}