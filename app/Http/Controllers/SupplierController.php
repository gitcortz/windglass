<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Http\Traits\Paginatable;
use Validator;

class SupplierController extends Controller
{
    use Paginatable;

    public function index()
    {
        return Supplier::paginate($this->getPerPage());
    }
 
    public function show(Supplier $supplier)
    {
        return $supplier;
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
            $supplier = Supplier::create($request->all());
            return response()->json($supplier, 201);
        }
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->all());

        return response()->json($supplier, 200);
    }

    public function delete(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json(null, 204);
    }
}
