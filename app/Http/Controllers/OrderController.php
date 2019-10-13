<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Http\Traits\Paginatable;
use Validator;

class OrderController extends Controller
{
    use Paginatable;

    public function index()
    {
        return Order::paginate($this->getPerPage());
    }
 
    public function show(Order $order)
    {
        return $order;
    }

    public function store(Request $request)
    {
        $rules = array (
            'order_date' => 'required|date',            
        );
        
        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($request->all(), $rules);
        if ($validator-> fails()){
            return response()->json($validator->errors(), 400);
        }
        else{
            $order = Order::create($request->all());
            return response()->json($order, 201);
        }
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());

        return response()->json($order, 200);
    }

    public function delete(Order $order)
    {
        $order->delete();

        return response()->json(null, 204);
    }
}
