<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Store;
use App\InventoryStock;
use App\InventoryMovement;
use App\Http\Resources\InventoryResource;
use App\Http\Resources\InventoryCollection;
use App\Http\Traits\Paginatable;
use App\Library\Services\Inventory\InventoryServiceInterface;
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


    public function products(Request $request)
    {
        $store_id = $request->store;
        $products = InventoryStock::where('store_id', $store_id)->paginate($this->getPerPage());
        return new InventoryCollection($products);
    }

    public function product(Request $request)
    {
        $store_id = $request->store;
        $stock_id = $request->stock;
        return (new InventoryResource(InventoryStock::where('id', $stock_id)->first()));

    }

    public function add_product(Request $request, InventoryServiceInterface $inventoryServiceInstance)
    {
        $count = InventoryStock::where('store_id', $request->store)
                    ->where('product_id', $request->product_id)
                    ->count();

        if ($count == 0) {
            $stock_id = $inventoryServiceInstance->createStock($request);
            $stock = new InventoryResource(InventoryStock::find($stock_id));
        
            return response()->json($stock, 201);
        }
        else {
            $json = [
                'status' => 'Failed',
                'message' => 'already exists'
            ];
            return response()->json($json, 400);
        }
        
    }

    public function move_product(Request $request, InventoryServiceInterface $inventoryServiceInstance)
    {
        $result = $inventoryServiceInstance->moveStock($request);
        
        return response()->json($result, 201);
    }



}
