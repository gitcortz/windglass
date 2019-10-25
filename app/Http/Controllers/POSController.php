<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PosSession;
use App\Order;
use App\Http\Traits\Paginatable;
use Validator;
use Carbon\Carbon;
use App\Library\Services\Pos\PosServiceInterface;
use App\Http\Resources\OrderResource;

class POSController extends Controller
{
    public function index()
    {
        return PosSession::paginate($this->getPerPage());
    }
 
    public function show(PosSession $store)
    {
        return $store;
    }

    public function open(Request $request)
    {
        $date = Carbon::now(); 
        $request->merge(['name' => $request->store_id.'-'.time()]);
        
        $store = PosSession::create($request->all());
        return response()->json($store, 201);
    }

    public function close(Request $request, PosSession $posSession)
    {
        if ( $posSession->pos_status == "open")
        {
            $date = Carbon::now(); 
            $request->request->add(['pos_status' => 2]);        
            $request->request->add(['closed_at' => $date]);        
            $posSession->update($request->all());

            return response()->json($posSession, 200);
        }
        else {
            $json = [
                'status' => 'Close POS Failed',
                'message' => 'already closed'
            ];
            return response()->json($json, 400);
        }
    }

    public function cash_in(PosSession $store)
    {
        return $store;
    }

    public function cash_out(PosSession $store)
    {
        return $store;
    }

    public function create_order(Request $request, PosServiceInterface $posServiceInstance)
    {
        $order_id = $posServiceInstance->createOrder($request);
        $order = Order::find($order_id);
        return (new OrderResource($order));
    }

    public function delivered(Request $request, PosServiceInterface $posServiceInstance)
    {
        $order_id = $posServiceInstance->delivered($request);
        return (new OrderResource($order));
    }
}
