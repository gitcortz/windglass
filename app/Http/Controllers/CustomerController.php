<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\Paginatable;
use App\Customer;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerCollection;
use Validator;

class CustomerController extends Controller
{
    use Paginatable;
    public function index(Request $request)
    {
        //return CustomerResource::collection(Customer::paginate($this->getPerPage()));
        // /return BookResource::collection(Book::with('ratings')->paginate(25));
        /*\DB::listen(function($query) {
            var_dump($query->sql);
        });*/
        return new CustomerCollection(Customer::paginate($this->getPerPage()));
        
    }
 
    public function show(Customer $customer)
    {
        /*\DB::listen(function($query) {
            var_dump($query->sql);
        });*/
        
        return ((new CustomerResource($customer))->additional([
            'meta' => [
                'anything' => 'Some Value'
            ]
        ]));
        
        //return response()->json(['data' => $customer, 'test' => Auth::guard('api')->user()], 200);
        //return $customer;
    }
    public function store(Request $request)
    {
        $rules = array (
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'address' => 'required|max:255',
            'city' => 'required|max:100',
        );
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($request->all(), $rules);
        if ($validator-> fails()){
            return response()->json($validator->errors(), 400);
        }
        else{
            $customer = Customer::create($request->all());
            return response()->json($customer, 201);
        }
    }
    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return response()->json($customer, 200);
    }
    public function delete(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}