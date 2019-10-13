<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\Paginatable;
use App\Customer;
use App\Http\Resources\CustomerResource;
use Validator;

class CustomerController extends Controller
{
    use Paginatable;

    public function index(Request $request)
    {
        //return CustomerResource::collection(Customer::paginate($this->getPerPage()));
        return Customer::paginate($this->getPerPage());

        //$customers = Customer::all();
        /*
        $query = Customer::where('name', $request->input('name'));
        return $query->paginate($this->getPerPage());
        */      

        /*
        $query = User::where('company_id', $request->input('company_id'));

        if ($request->has('last_name'))
        {
            $query->where('last_name', 'LIKE', '%' . $request->input('last_name') . '%');
        }

        if ($request->has('name'))
        {
            $query->where(function ($q) use ($request)
            {
                return $q->where('first_name', 'LIKE', $request->input('name') . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->input('name') . '%');
            });
        }

        $query->whereHas('roles', function ($q) use ($request)
        {
            return $q->whereIn('id', $request->input('roles'));
        })
            ->whereHas('clients', function ($q) use ($request)
            {
                return $q->whereHas('industry_id', $request->input('industry'));
            });

        return $query->get();
        */
    }
 
    public function show(Customer $customer)
    {
        return response()->json(['data' => $customer, 'test' => Auth::guard('api')->user()], 200);

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
