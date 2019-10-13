<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\Paginatable;
use App\User;
use Validator;

class UserController extends Controller
{
    use Paginatable;

    public function index(Request $request)
    {
        return User::paginate($this->getPerPage());
    }
 
    public function show(User $user)
    {
       return $user;
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
            $user = User::create($request->all());
            return response()->json($user, 201);
        }
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
