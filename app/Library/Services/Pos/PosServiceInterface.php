<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Pos;
use Illuminate\Http\Request;


Interface PosServiceInterface
{
    public function createOrder(Request $request);
    public function voidOrder(Request $request);
    public function cashIn(Request $request);
    public function cashOut(Request $request);
    public function summary($pos_session_id);
    public function sales($pos_session_id);
}