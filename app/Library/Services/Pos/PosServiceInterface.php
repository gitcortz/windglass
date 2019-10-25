<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Pos;
use Illuminate\Http\Request;


Interface PosServiceInterface
{
    public function createOrder(Request $request);
 
}