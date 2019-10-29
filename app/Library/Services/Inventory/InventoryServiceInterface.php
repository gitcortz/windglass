<?php

namespace App\Library\Services\Inventory;
use Illuminate\Http\Request;


Interface InventoryServiceInterface
{
    public function createStock(Request $request);
    
}