<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrderItems;
use Validator;

class OrderItemController extends Controller
{
    public function index()
    {
        return OrderItems::all();
    }
 
    public function show(OrderItems $orderItem)
    {
        return $orderItem;
    }

    public function store(Request $request)
    {
        $rules = array (
            'order_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
            'discount' => 'required|numeric',
        );
        
        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($request->all(), $rules);
        if ($validator-> fails()){
            return response()->json($validator->errors(), 400);
        }
        else{
            $orderItem = OrderItems::create($request->all());
            return response()->json($orderItem, 201);
        }
    }

    public function update(Request $request, OrderItems $orderItem)
    {
        $orderItem->update($request->all());

        return response()->json($orderItem, 200);
    }

    public function delete(OrderItems $orderItem)
    {
        $orderItem->delete();

        return response()->json(null, 204);
    }
}
