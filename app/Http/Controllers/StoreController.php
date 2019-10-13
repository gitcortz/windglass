<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\Http\Traits\Paginatable;
use Validator;

class StoreController extends Controller
{
    use Paginatable;

    public function index()
    {
        return Store::paginate($this->getPerPage());
    }
 
    public function show(Store $store)
    {
        return $store;
    }

    public function store(Request $request)
    {
        $rules = array (
            'name' => 'required|max:255',
        );

        $data = json_decode($request->getContent(), true);

        $validator = Validator::make($request->all(), $rules);
        if ($validator-> fails()){
            return response()->json($validator->errors(), 400);
        }
        else{
            $store = Store::create($request->all());
            return response()->json($store, 201);
        }
    }

    public function update(Request $request, Store $store)
    {
        $store->update($request->all());

        return response()->json($store, 200);
    }

    public function delete(Store $store)
    {
        $store->delete();

        return response()->json(null, 204);
    }
}
